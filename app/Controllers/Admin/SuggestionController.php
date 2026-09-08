<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Services\AuditService;
use App\Services\SuggestionService;

class SuggestionController extends Controller
{
    /**
     * Display all member suggestions with filtering and KPIs
     */
    public function index(): void
    {
        $status = $this->request->query('status');
        $category = $this->request->query('category');
        $search = $this->request->query('q');

        $suggestions = SuggestionService::getAllSuggestions($status, $category, $search);
        $stats = SuggestionService::getSuggestionStats();
        $categories = SuggestionService::getCategories();
        $statuses = SuggestionService::getStatuses();

        $this->render('admin.suggestions.index', [
            'title' => 'จัดการข้อเสนอแนะและเสียงจากสมาชิก (Member Voice)',
            'suggestions' => $suggestions,
            'stats' => $stats,
            'categories' => $categories,
            'statuses' => $statuses,
            'selectedStatus' => $status,
            'selectedCategory' => $category,
            'search' => $search,
        ], 'layouts.admin');
    }

    /**
     * View suggestion details
     */
    public function show(string $id): void
    {
        $suggestion = SuggestionService::getSuggestionById((int)$id);
        if (!$suggestion) {
            Session::flash('error', 'ไม่พบข้อเสนอแนะที่ระบุ');
            $this->redirect(url('admin/suggestions'));
            return;
        }

        $categories = SuggestionService::getCategories();
        $statuses = SuggestionService::getStatuses();

        $this->render('admin.suggestions.show', [
            'title' => "ข้อเสนอแนะ: {$suggestion['suggestion_no']}",
            'suggestion' => $suggestion,
            'categories' => $categories,
            'statuses' => $statuses,
        ], 'layouts.admin');
    }

    /**
     * Update status and response comment
     */
    public function updateStatus(string $id): void
    {
        $status = (string)$this->request->input('status', 'under_review');
        $response = trim((string)$this->request->input('admin_response', ''));
        $adminUserId = Auth::id() ?? 1;

        $ok = SuggestionService::updateStatusAndResponse((int)$id, $status, $response, $adminUserId);

        if ($ok) {
            Session::flash('success', 'บันทึกสถานะและการตอบกลับข้อเสนอแนะเรียบร้อยแล้ว');
        } else {
            Session::flash('error', 'ไม่สามารถบันทึกข้อมูลได้');
        }

        $this->redirect(url('admin/suggestions'));
    }

    /**
     * Delete suggestion
     */
    public function destroy(string $id): void
    {
        $sug = SuggestionService::getSuggestionById((int)$id);
        if ($sug) {
            Database::execute("DELETE FROM member_suggestions WHERE id = ?", [(int)$id]);
            AuditService::log('suggestion', 'delete', (string)$id, $sug);
            Session::flash('success', 'ลบข้อเสนอแนะเรียบร้อยแล้ว');
        }

        $this->redirect(url('admin/suggestions'));
    }
}
