<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Services\AuditService;

class ContactMessageController extends Controller
{
    public function index(): void
    {
        $status = $this->request->query('status');
        $search = $this->request->query('q');

        $where = ["deleted_at IS NULL"];
        $params = [];

        if (!empty($status)) {
            $where[] = "status = ?";
            $params[] = $status;
        }

        if (!empty($search)) {
            $where[] = "(name LIKE ? OR phone LIKE ? OR email LIKE ? OR subject LIKE ?)";
            $term = "%{$search}%";
            $params = array_merge($params, [$term, $term, $term, $term]);
        }

        $whereSql = implode(" AND ", $where);
        $sql = "SELECT cm.*, u.name as responder_name 
                FROM contact_messages cm 
                LEFT JOIN users u ON cm.responded_by = u.id 
                WHERE {$whereSql} 
                ORDER BY cm.created_at DESC";

        $messages = Database::query($sql, $params);

        // Count by status
        $counts = [
            'all' => (int)Database::first("SELECT COUNT(*) as c FROM contact_messages WHERE deleted_at IS NULL")['c'],
            'new' => (int)Database::first("SELECT COUNT(*) as c FROM contact_messages WHERE status = 'new' AND deleted_at IS NULL")['c'],
            'in_progress' => (int)Database::first("SELECT COUNT(*) as c FROM contact_messages WHERE status = 'in_progress' AND deleted_at IS NULL")['c'],
            'answered' => (int)Database::first("SELECT COUNT(*) as c FROM contact_messages WHERE status = 'answered' AND deleted_at IS NULL")['c'],
            'closed' => (int)Database::first("SELECT COUNT(*) as c FROM contact_messages WHERE status = 'closed' AND deleted_at IS NULL")['c'],
        ];

        $this->render('admin.contact_messages.index', [
            'title' => 'จัดการข้อความติดต่อจากผู้ใช้งาน',
            'messages' => $messages,
            'status' => $status,
            'search' => $search,
            'counts' => $counts,
        ], 'layouts.admin');
    }

    public function show(string $id): void
    {
        $message = Database::first("SELECT cm.*, u.name as responder_name 
                                    FROM contact_messages cm 
                                    LEFT JOIN users u ON cm.responded_by = u.id 
                                    WHERE cm.id = ? AND cm.deleted_at IS NULL 
                                    LIMIT 1", [(int)$id]);

        if (!$message) {
            Session::flash('error', 'ไม่พบข้อความติดต่อที่ระบุ');
            $this->redirect(url('admin/contact-messages'));
            return;
        }

        // If status was 'new', mark as 'in_progress' automatically upon reading
        if ($message['status'] === 'new') {
            Database::execute("UPDATE contact_messages SET status = 'in_progress', updated_at = NOW() WHERE id = ?", [(int)$id]);
            $message['status'] = 'in_progress';
            AuditService::log('contact_messages', 'update_status', (string)$id, ['status' => 'new'], ['status' => 'in_progress']);
        }

        $this->render('admin.contact_messages.show', [
            'title' => 'รายละเอียดข้อความติดต่อ: ' . $message['subject'],
            'message' => $message,
        ], 'layouts.admin');
    }

    public function updateStatus(string $id): void
    {
        $message = Database::first("SELECT * FROM contact_messages WHERE id = ? AND deleted_at IS NULL LIMIT 1", [(int)$id]);
        if (!$message) {
            Session::flash('error', 'ไม่พบข้อความติดต่อ');
            $this->redirect(url('admin/contact-messages'));
            return;
        }

        $status = $this->request->input('status');
        $staffNotes = $this->request->input('staff_notes');
        $staffReply = $this->request->input('staff_reply');

        if (!in_array($status, ['new', 'in_progress', 'answered', 'closed'], true)) {
            $status = $message['status'];
        }

        Database::execute(
            "UPDATE contact_messages 
             SET status = ?, staff_notes = ?, staff_reply = ?, responded_by = ?, responded_at = NOW(), updated_at = NOW() 
             WHERE id = ?",
            [$status, $staffNotes, $staffReply, Auth::id(), (int)$id]
        );

        AuditService::log(
            'contact_messages',
            'update',
            (string)$id,
            $message,
            ['status' => $status, 'staff_notes' => $staffNotes, 'staff_reply' => $staffReply]
        );

        Session::flash('success', 'บันทึกการอัปเดตและสถานะข้อความเรียบร้อยแล้ว');
        $this->redirect(url("admin/contact-messages/{$id}"));
    }

    public function destroy(string $id): void
    {
        $message = Database::first("SELECT * FROM contact_messages WHERE id = ? LIMIT 1", [(int)$id]);
        if ($message) {
            Database::execute("UPDATE contact_messages SET deleted_at = NOW() WHERE id = ?", [(int)$id]);
            AuditService::log('contact_messages', 'delete', (string)$id, $message);
        }

        Session::flash('success', 'ลบข้อความติดต่อเรียบร้อยแล้ว');
        $this->redirect(url('admin/contact-messages'));
    }
}
