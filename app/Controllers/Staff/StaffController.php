<?php

declare(strict_types=1);

namespace App\Controllers\Staff;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Services\AuditService;
use App\Services\StaffService;

class StaffController extends Controller
{
    public function dashboard(): void
    {
        $kpis = StaffService::getDashboardKPIs();
        $recentLoans = StaffService::getLoanApplications('submitted');
        $recentMembers = StaffService::searchMembers(null, null, 5);

        $this->render('staff.dashboard', [
            'title' => 'Staff Dashboard — ระบบงานเจ้าหน้าที่สหกรณ์',
            'kpis' => $kpis,
            'recentLoans' => $recentLoans,
            'recentMembers' => $recentMembers,
        ], 'layouts.admin');
    }

    public function members(): void
    {
        $keyword = $this->request->query('q');
        $department = $this->request->query('dept');
        $members = StaffService::searchMembers($keyword, $department, 50);
        $departments = Database::query("SELECT DISTINCT department FROM members WHERE department IS NOT NULL AND department != ''");

        $this->render('staff.members', [
            'title' => 'จัดการและค้นหาข้อมูลสมาชิก (Member Management)',
            'members' => $members,
            'departments' => array_column($departments, 'department'),
            'keyword' => $keyword,
            'selectedDept' => $department,
        ], 'layouts.admin');
    }

    public function memberDetail(): void
    {
        $id = (int)$this->request->query('id');
        $data = StaffService::getMember360($id);

        if (!$data) {
            Session::flash('error', 'ไม่พบข้อมูลสมาชิกที่ระบุ');
            $this->redirect(url('staff/members'));
            return;
        }

        $this->render('staff.member_detail', [
            'title' => "ข้อมูลสมาชิก 360° — {$data['member']['first_name']} {$data['member']['last_name']}",
            'data' => $data,
        ], 'layouts.admin');
    }

    public function loans(): void
    {
        $status = $this->request->query('status');
        $applications = StaffService::getLoanApplications($status);

        $this->render('staff.loans', [
            'title' => 'ตรวจสอบและอนุมัติคำขอกู้เงิน (Loan Management)',
            'applications' => $applications,
            'currentStatus' => $status,
        ], 'layouts.admin');
    }

    public function reviewLoan(): void
    {
        $appId = (int)$this->request->input('application_id');
        $action = (string)$this->request->input('action'); // approved, rejected, document_review
        $comment = trim((string)$this->request->input('comment'));
        $staffUserId = Auth::id() ?? 1;

        StaffService::reviewLoanApplication($appId, $action, $comment, $staffUserId);

        AuditService::log('loan', $action, (string)$appId, null, ['comment' => $comment]);

        $msg = match($action) {
            'approved' => 'อนุมัติคำขอกู้เงินเรียบร้อยแล้ว',
            'rejected' => 'ปฏิเสธคำขอกู้เงินเรียบร้อยแล้ว',
            'document_review' => 'ส่งคำขอเอกสารเพิ่มเติมไปยังสมาชิกเรียบร้อยแล้ว',
            default => 'บันทึกการตรวจสอบเรียบร้อยแล้ว'
        };

        Session::flash('success', $msg);
        $this->redirect(url('staff/loans'));
    }

    public function welfare(): void
    {
        $applications = Database::query("SELECT a.*, wt.name as welfare_name, m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as member_name, m.department, m.phone 
            FROM welfare_applications a 
            JOIN welfare_types wt ON a.welfare_type_id = wt.id 
            JOIN members m ON a.member_id = m.id 
            ORDER BY a.created_at DESC");

        $this->render('staff.welfare', [
            'title' => 'ตรวจสอบและอนุมัติสวัสดิการสมาชิก (Welfare Claims)',
            'applications' => $applications,
        ], 'layouts.admin');
    }

    public function reviewWelfare(): void
    {
        $appId = (int)$this->request->input('application_id');
        $action = (string)$this->request->input('action'); // approved, rejected
        $comment = trim((string)$this->request->input('comment'));

        Database::execute(
            "UPDATE welfare_applications SET status = ?, comment = ?, reviewed_by = ?, reviewed_at = NOW(), updated_at = NOW() WHERE id = ?",
            [$action, $comment, Auth::id() ?? 1, $appId]
        );

        AuditService::log('welfare', $action, (string)$appId, null, ['comment' => $comment]);

        Session::flash('success', 'บันทึกการพิจารณาคำขอสวัสดิการเรียบร้อยแล้ว');
        $this->redirect(url('staff/welfare'));
    }

    public function reports(): void
    {
        $reportType = $this->request->query('type') ?? 'members';
        $reportData = StaffService::generateReport($reportType);

        $this->render('staff.reports', [
            'title' => 'ระบบรายงานและส่งออกข้อมูล (Reporting System)',
            'reportType' => $reportType,
            'reportData' => $reportData,
        ], 'layouts.admin');
    }
}
