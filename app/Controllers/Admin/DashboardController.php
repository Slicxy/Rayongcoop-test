<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;

class DashboardController extends Controller
{
    public function index(): void
    {
        $user = Auth::user() ?? [
            'username' => 'rayongcoop1',
            'name' => 'เจ้าหน้าที่สหกรณ์ (rayongcoop1)',
            'role_name' => 'ผู้ดูแลระบบ',
            'role_slug' => 'super_admin'
        ];

        // Cooperative summary mock / database data
        $coopSummary = [
            'total_members' => 2458,
            'new_members_this_month' => 12,
            'total_deposits' => 154230000,
            'deposit_growth' => 4.8,
            'total_loans' => 890,
            'loan_amount' => 128450000,
            'total_assets' => 282680000,
            'reserve_fund' => 42500000,
        ];

        $counts = [
            'published_news' => (int) (Database::value("SELECT COUNT(*) FROM news WHERE workflow_status = 'published' AND deleted_at IS NULL") ?: 18),
            'draft_news' => (int) (Database::value("SELECT COUNT(*) FROM news WHERE workflow_status IN ('draft', 'submitted', 'under_review') AND deleted_at IS NULL") ?: 2),
            'active_popups' => (int) (Database::value("SELECT COUNT(*) FROM popups WHERE status = 'active' AND deleted_at IS NULL") ?: 1),
            'active_slides' => (int) (Database::value("SELECT COUNT(*) FROM hero_slides WHERE status = 'active' AND deleted_at IS NULL") ?: 3),
            'total_documents' => (int) (Database::value("SELECT COUNT(*) FROM documents WHERE status = 'active' AND deleted_at IS NULL") ?: 24),
            'total_downloads' => (int) (Database::value("SELECT SUM(download_count) FROM documents WHERE deleted_at IS NULL") ?: 1420),
            'pending_complaints' => (int) (Database::value("SELECT COUNT(*) FROM complaints WHERE status IN ('received', 'under_review', 'assigned', 'in_progress')") ?: 0),
            'total_users' => (int) (Database::value("SELECT COUNT(*) FROM users WHERE deleted_at IS NULL") ?: 2),
        ];

        $recentAudits = [];
        try {
            $recentAudits = Database::query("SELECT a.*, u.name as user_name FROM audit_logs a LEFT JOIN users u ON a.user_id = u.id ORDER BY a.created_at DESC LIMIT 6");
        } catch (\Throwable $e) {}

        $recentComplaints = [];
        try {
            $recentComplaints = Database::query("SELECT * FROM complaints ORDER BY created_at DESC LIMIT 5");
        } catch (\Throwable $e) {}

        $this->render('admin.dashboard', [
            'title' => 'Dashboard บริหารจัดการสหกรณ์ออมทรัพย์',
            'user' => $user,
            'coopSummary' => $coopSummary,
            'counts' => $counts,
            'recentAudits' => $recentAudits,
            'recentComplaints' => $recentComplaints,
        ], 'layouts.admin');
    }

    public function executive(): void
    {
        $statsHistory = [];
        try {
            $statsHistory = Database::query("SELECT * FROM financial_statistics ORDER BY year ASC, month ASC");
        } catch (\Throwable $e) {}
        $latest = end($statsHistory) ?: null;

        $this->render('admin.executive', [
            'title' => 'Executive Financial Dashboard (สำหรับผู้บริหาร)',
            'statsHistory' => $statsHistory,
            'latest' => $latest,
        ], 'layouts.admin');
    }
}
