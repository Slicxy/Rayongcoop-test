<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Services\AuditService;

class EventController extends Controller
{
    public function index(): void
    {
        $category = $this->request->query('cat');
        $status = $this->request->query('status');

        $where = ["deleted_at IS NULL"];
        $params = [];

        if (!empty($category)) {
            $where[] = "category = ?";
            $params[] = $category;
        }

        if (!empty($status)) {
            $where[] = "status = ?";
            $params[] = $status;
        }

        $whereSql = implode(" AND ", $where);
        $events = Database::query(
            "SELECT * FROM events 
             WHERE {$whereSql} 
             ORDER BY start_date DESC, start_time ASC",
            $params
        );

        $this->render('admin.events.index', [
            'title' => 'จัดการปฏิทินกิจกรรมและกำหนดการ',
            'events' => $events,
            'category' => $category,
            'status' => $status,
        ], 'layouts.admin');
    }

    public function create(): void
    {
        $this->render('admin.events.create', [
            'title' => 'เพิ่มกิจกรรม/กำหนดการใหม่',
        ], 'layouts.admin');
    }

    public function store(): void
    {
        $data = $this->validate([
            'title' => 'required',
            'start_date' => 'required',
            'category' => 'required',
        ]);

        $slug = str_slug($data['title']) . '-' . time();

        $sql = "INSERT INTO events 
                (title, slug, description, category, start_date, end_date, start_time, end_time, location, related_link, status, is_featured, created_by, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $id = Database::insert($sql, [
            $data['title'],
            $slug,
            $this->request->input('description'),
            $data['category'],
            $data['start_date'],
            $this->request->input('end_date') ?: null,
            $this->request->input('start_time') ?: null,
            $this->request->input('end_time') ?: null,
            $this->request->input('location'),
            $this->request->input('related_link'),
            $this->request->input('status', 'upcoming'),
            (int)($this->request->input('is_featured') ? 1 : 0),
            Auth::id()
        ]);

        AuditService::log('events', 'create', (string)$id, null, ['title' => $data['title']]);
        Session::flash('success', 'เพิ่มกิจกรรมในปฏิทินเรียบร้อยแล้ว');
        $this->redirect(url('admin/events'));
    }

    public function edit(string $id): void
    {
        $event = Database::first("SELECT * FROM events WHERE id = ? AND deleted_at IS NULL LIMIT 1", [(int)$id]);
        if (!$event) {
            Session::flash('error', 'ไม่พบกิจกรรมที่ระบุ');
            $this->redirect(url('admin/events'));
            return;
        }

        $this->render('admin.events.edit', [
            'title' => 'แก้ไขกิจกรรม: ' . $event['title'],
            'event' => $event,
        ], 'layouts.admin');
    }

    public function update(string $id): void
    {
        $event = Database::first("SELECT * FROM events WHERE id = ? AND deleted_at IS NULL LIMIT 1", [(int)$id]);
        if (!$event) {
            Session::flash('error', 'ไม่พบกิจกรรมที่ระบุ');
            $this->redirect(url('admin/events'));
            return;
        }

        $data = $this->validate([
            'title' => 'required',
            'start_date' => 'required',
            'category' => 'required',
        ]);

        $sql = "UPDATE events 
                SET title = ?, description = ?, category = ?, start_date = ?, end_date = ?, start_time = ?, end_time = ?, location = ?, related_link = ?, status = ?, is_featured = ?, updated_by = ?, updated_at = NOW() 
                WHERE id = ?";

        Database::execute($sql, [
            $data['title'],
            $this->request->input('description'),
            $data['category'],
            $data['start_date'],
            $this->request->input('end_date') ?: null,
            $this->request->input('start_time') ?: null,
            $this->request->input('end_time') ?: null,
            $this->request->input('location'),
            $this->request->input('related_link'),
            $this->request->input('status', 'upcoming'),
            (int)($this->request->input('is_featured') ? 1 : 0),
            Auth::id(),
            (int)$id
        ]);

        AuditService::log('events', 'update', (string)$id, $event, $data);
        Session::flash('success', 'บันทึกการแก้ไขกิจกรรมเรียบร้อยแล้ว');
        $this->redirect(url('admin/events'));
    }

    public function destroy(string $id): void
    {
        $event = Database::first("SELECT * FROM events WHERE id = ? LIMIT 1", [(int)$id]);
        if ($event) {
            Database::execute("UPDATE events SET deleted_at = NOW(), updated_by = ? WHERE id = ?", [Auth::id(), (int)$id]);
            AuditService::log('events', 'delete', (string)$id, $event);
        }

        Session::flash('success', 'ลบกิจกรรมเรียบร้อยแล้ว');
        $this->redirect(url('admin/events'));
    }
}
