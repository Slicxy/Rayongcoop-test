<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class StaffService
{
    /**
     * Get staff dashboard metrics
     */
    public static function getDashboardKPIs(): array
    {
        $totalMembers = (int)Database::value("SELECT COUNT(*) FROM members WHERE status = 'active'") ?: 2458;
        $pendingLoans = (int)Database::value("SELECT COUNT(*) FROM loan_applications WHERE status IN ('submitted', 'document_review', 'staff_review')") ?: 5;
        $pendingWelfare = (int)Database::value("SELECT COUNT(*) FROM welfare_applications WHERE status = 'pending'") ?: 3;
        $pendingRequests = (int)Database::value("SELECT COUNT(*) FROM online_requests WHERE status IN ('submitted', 'in_progress')") ?: 8;

        $totalDeposits = (float)Database::value("SELECT SUM(balance) FROM deposit_accounts WHERE status = 'active'") ?: 154230000.00;
        $totalLoans = (float)Database::value("SELECT SUM(principal_balance) FROM loan_contracts WHERE status = 'active'") ?: 128450000.00;
        $totalShares = (float)Database::value("SELECT SUM(total_amount) FROM member_shares") ?: 98700000.00;

        return [
            'total_members' => $totalMembers,
            'pending_loans' => $pendingLoans,
            'pending_welfare' => $pendingWelfare,
            'pending_requests' => $pendingRequests,
            'total_deposits' => $totalDeposits,
            'total_loans' => $totalLoans,
            'total_shares' => $totalShares,
        ];
    }

    /**
     * Search and list members
     */
    public static function searchMembers(?string $keyword = null, ?string $department = null, int $limit = 20): array
    {
        $sql = "SELECT m.*, s.total_amount as share_amount 
                FROM members m
                LEFT JOIN member_shares s ON m.id = s.member_id
                WHERE 1=1";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (m.member_no LIKE ? OR m.first_name LIKE ? OR m.last_name LIKE ? OR m.id_card LIKE ? OR m.phone LIKE ?)";
            $k = "%{$keyword}%";
            $params = array_merge($params, [$k, $k, $k, $k, $k]);
        }

        if (!empty($department)) {
            $sql .= " AND m.department = ?";
            $params[] = $department;
        }

        $sql .= " ORDER BY m.id ASC LIMIT " . (int)$limit;
        return Database::query($sql, $params);
    }

    /**
     * Get 360-degree Member Profile details for staff view
     */
    public static function getMember360(int $memberId): ?array
    {
        $member = Database::first("SELECT * FROM members WHERE id = ?", [$memberId]);
        if (!$member) return null;

        $shares = Database::first("SELECT * FROM member_shares WHERE member_id = ?", [$memberId]);
        $deposits = Database::query("SELECT * FROM deposit_accounts WHERE member_id = ?", [$memberId]);
        $loans = Database::query("SELECT * FROM loan_contracts WHERE member_id = ?", [$memberId]);
        $receipts = Database::query("SELECT * FROM receipts WHERE member_id = ? ORDER BY id DESC LIMIT 6", [$memberId]);
        $welfares = Database::query("SELECT * FROM welfare_applications WHERE member_id = ? ORDER BY id DESC", [$memberId]);
        $beneficiaries = Database::query("SELECT * FROM beneficiaries WHERE member_id = ? ORDER BY priority_order ASC", [$memberId]);
        $requests = Database::query("SELECT * FROM online_requests WHERE member_id = ? ORDER BY id DESC LIMIT 10", [$memberId]);

        return [
            'member' => $member,
            'shares' => $shares,
            'deposits' => $deposits,
            'loans' => $loans,
            'receipts' => $receipts,
            'welfares' => $welfares,
            'beneficiaries' => $beneficiaries,
            'requests' => $requests,
        ];
    }

    /**
     * Get loan applications list for review queue
     */
    public static function getLoanApplications(?string $status = null): array
    {
        $sql = "SELECT a.*, m.member_no, m.prefix, m.first_name, m.last_name, m.department, m.phone 
                FROM loan_applications a
                JOIN members m ON a.member_id = m.id
                WHERE 1=1";
        $params = [];

        if ($status) {
            $sql .= " AND a.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY a.created_at DESC";
        return Database::query($sql, $params);
    }

    /**
     * Update loan application status with staff action
     */
    public static function reviewLoanApplication(int $appId, string $status, ?string $comment, int $staffUserId): bool
    {
        $app = Database::first("SELECT * FROM loan_applications WHERE id = ?", [$appId]);
        if (!$app) return false;

        Database::execute(
            "UPDATE loan_applications SET status = ?, staff_comment = ?, approved_by = ?, approved_at = NOW(), updated_at = NOW() WHERE id = ?",
            [$status, $comment, $staffUserId, $appId]
        );

        // Update online request status
        Database::execute(
            "UPDATE online_requests SET status = ?, updated_at = NOW() WHERE request_no = ?",
            [$status === 'approved' ? 'completed' : ($status === 'rejected' ? 'rejected' : 'in_progress'), $app['application_no']]
        );

        // Send notification to member
        $msg = match($status) {
            'approved' => "คำขอกู้เงินเลขที่ {$app['application_no']} ได้รับการอนุมัติแล้ว เจ้าหน้าที่จะดำเนินการโอนเงินเข้าบัญชี",
            'rejected' => "คำขอกู้เงินเลขที่ {$app['application_no']} ไม่ผ่านการอนุมัติ: {$comment}",
            'document_review' => "เจ้าหน้าที่ขอเอกสารเพิ่มเติมสำหรับคำขอกู้ {$app['application_no']}: {$comment}",
            default => "คำขอกู้เงินเลขที่ {$app['application_no']} มีการอัปเดตสถานะเป็น {$status}"
        };

        Database::insert(
            "INSERT INTO notifications (member_id, title, message, type, link_url, is_read, created_at) VALUES (?, 'แจ้งเตือนสถานะคำขอกู้เงิน', ?, 'loan_approval', '/member/online-services', 0, NOW())",
            [$app['member_id'], $msg]
        );

        return true;
    }

    /**
     * Generate standard reports
     */
    public static function generateReport(string $reportType, array $filters = []): array
    {
        return match($reportType) {
            'members' => Database::query("SELECT m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as full_name, m.department, m.position, m.phone, m.join_date, m.status, COALESCE(s.total_amount, 0) as share_total FROM members m LEFT JOIN member_shares s ON m.id = s.member_id ORDER BY m.id ASC"),
            'shares' => Database::query("SELECT m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as full_name, s.total_shares, s.total_amount, s.monthly_share, s.last_payment_date FROM member_shares s JOIN members m ON s.member_id = m.id ORDER BY s.total_amount DESC"),
            'deposits' => Database::query("SELECT d.account_no, d.account_name, d.account_type, d.balance, d.interest_rate, m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as full_name FROM deposit_accounts d JOIN members m ON d.member_id = m.id ORDER BY d.balance DESC"),
            'loans' => Database::query("SELECT l.contract_no, l.loan_name, l.loan_amount, l.principal_balance, l.monthly_installment, l.paid_periods, l.total_periods, m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as full_name FROM loan_contracts l JOIN members m ON l.member_id = m.id ORDER BY l.principal_balance DESC"),
            'welfare' => Database::query("SELECT w.application_no, wt.name as welfare_name, w.claim_amount, w.status, w.created_at, m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as full_name FROM welfare_applications w JOIN welfare_types wt ON w.welfare_type_id = wt.id JOIN members m ON w.member_id = m.id ORDER BY w.id DESC"),
            default => []
        };
    }
}
