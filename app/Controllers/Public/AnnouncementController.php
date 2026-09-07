<?php

declare(strict_types=1);

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;

class AnnouncementController extends Controller
{
    /**
     * Public Announcements List
     */
    public function index(): void
    {
        $priority = $this->request->query('priority');
        $keyword = $this->request->query('q');

        $where = [
            "status = 'published'",
            "deleted_at IS NULL",
            "publication_date <= CURDATE()",
            "(expiry_date IS NULL OR expiry_date >= CURDATE())"
        ];
        $params = [];

        if (!empty($priority) && in_array($priority, ['urgent', 'important', 'general'], true)) {
            $where[] = "priority = ?";
            $params[] = $priority;
        }

        if (!empty($keyword)) {
            $where[] = "(title LIKE ? OR content LIKE ? OR resolution_no LIKE ?)";
            $term = "%{$keyword}%";
            $params = array_merge($params, [$term, $term, $term]);
        }

        $whereSql = implode(" AND ", $where);
        $sql = "SELECT * FROM important_announcements 
                WHERE {$whereSql} 
                ORDER BY is_pinned DESC, priority = 'urgent' DESC, priority = 'important' DESC, publication_date DESC, created_at DESC";

        $announcements = Database::query($sql, $params);

        $this->render('public.announcements.index', [
            'title' => 'ประกาศสำคัญสหกรณ์ออมทรัพย์สาธารณสุขระยอง จำกัด',
            'announcements' => $announcements,
            'selectedPriority' => $priority,
            'keyword' => $keyword,
        ]);
    }

    /**
     * Public Announcement Detail
     */
    public function show(string $slugOrId): void
    {
        $where = "deleted_at IS NULL AND (slug = ? OR id = ?)";
        $announcement = Database::first("SELECT * FROM important_announcements WHERE {$where} LIMIT 1", [$slugOrId, is_numeric($slugOrId) ? (int)$slugOrId : 0]);

        if (!$announcement || $announcement['status'] !== 'published') {
            $this->response->setStatusCode(404);
            $this->render('public.404', ['title' => '404 - ไม่พบประกาศสำคัญ'], 'layouts.public');
            return;
        }

        // Check if expired for public view
        if (!empty($announcement['expiry_date']) && strtotime($announcement['expiry_date']) < strtotime(date('Y-m-d'))) {
            Session::flash('error', 'ประกาศฉบับนี้สิ้นสุดระยะเวลาการเผยแพร่แล้ว');
            $this->redirect(url('announcements'));
            return;
        }

        // Increment view count
        Database::execute("UPDATE important_announcements SET view_count = view_count + 1 WHERE id = ?", [$announcement['id']]);

        // Get related active announcements
        $related = Database::query(
            "SELECT * FROM important_announcements 
             WHERE status = 'published' AND deleted_at IS NULL AND id != ? AND publication_date <= CURDATE() AND (expiry_date IS NULL OR expiry_date >= CURDATE())
             ORDER BY publication_date DESC LIMIT 4",
            [$announcement['id']]
        );

        $this->render('public.announcements.show', [
            'title' => $announcement['title'] . ' — ประกาศสำคัญ สอ.สธ.ระยอง',
            'announcement' => $announcement,
            'related' => $related,
        ]);
    }
}
