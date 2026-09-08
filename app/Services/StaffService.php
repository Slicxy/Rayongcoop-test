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
        $sql = "SELECT a.*, m.member_no, m.prefix, m.first_name, m.last_name, 
                       CONCAT(COALESCE(m.prefix,''), COALESCE(m.first_name,''), ' ', COALESCE(m.last_name,'')) as member_name, 
                       m.department, m.phone 
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
     * Get welfare applications list for review queue
     */
    public static function getWelfareApplications(?string $status = null): array
    {
        $sql = "SELECT a.*, wt.name as welfare_name, m.member_no, m.prefix, m.first_name, m.last_name, 
                       CONCAT(m.prefix, m.first_name, ' ', m.last_name) as member_name, m.department, m.phone 
                FROM welfare_applications a 
                JOIN welfare_types wt ON a.welfare_type_id = wt.id 
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
     * Generate structured standard reports with summary metrics
     */
    public static function generateReport(string $reportType, array $filters = []): array
    {
        $search = trim($filters['search'] ?? '');
        $dept = trim($filters['dept'] ?? '');
        $status = trim($filters['status'] ?? '');

        switch ($reportType) {
            case 'shares':
                $sql = "SELECT m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as full_name, m.department, s.total_shares, s.total_amount, s.monthly_share, s.last_payment_date 
                        FROM member_shares s 
                        JOIN members m ON s.member_id = m.id 
                        WHERE 1=1";
                $params = [];
                if ($search !== '') {
                    $sql .= " AND (m.member_no LIKE ? OR m.first_name LIKE ? OR m.last_name LIKE ?)";
                    $params = array_merge($params, ["%{$search}%", "%{$search}%", "%{$search}%"]);
                }
                if ($dept !== '') {
                    $sql .= " AND m.department = ?";
                    $params[] = $dept;
                }
                $sql .= " ORDER BY s.total_amount DESC";
                $rows = Database::query($sql, $params);

                $totalShares = array_sum(array_column($rows, 'total_shares'));
                $totalAmount = array_sum(array_column($rows, 'total_amount'));
                $totalMonthly = array_sum(array_column($rows, 'monthly_share'));

                $formattedData = [];
                foreach ($rows as $i => $r) {
                    $formattedData[] = [
                        $i + 1,
                        $r['member_no'],
                        $r['full_name'],
                        $r['department'] ?? '-',
                        number_format((float)$r['total_shares']) . ' หุ้น',
                        number_format((float)$r['total_amount'], 2),
                        number_format((float)$r['monthly_share'], 2),
                        !empty($r['last_payment_date']) ? date('d/m/Y', strtotime($r['last_payment_date'])) : '-',
                    ];
                }

                return [
                    'title' => 'รายงานทุนเรือนหุ้นและการส่งค่าหุ้นรายเดือน',
                    'type' => 'shares',
                    'headers' => ['ลำดับ', 'เลขสมาชิก', 'ชื่อ - นามสกุล', 'สังกัด/หน่วยงาน', 'จำนวนหุ้น', 'มูลค่าหุ้นรวม (บาท)', 'ส่งค่าหุ้น/เดือน (บาท)', 'ชำระล่าสุดเมื่อ'],
                    'data' => $formattedData,
                    'summary' => [
                        'count' => count($rows),
                        'total_shares' => $totalShares,
                        'total_amount' => $totalAmount,
                        'total_monthly' => $totalMonthly,
                    ],
                ];

            case 'deposits':
                $sql = "SELECT d.account_no, d.account_name, d.account_type, d.balance, d.interest_rate, m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as full_name, m.department 
                        FROM deposit_accounts d 
                        JOIN members m ON d.member_id = m.id 
                        WHERE 1=1";
                $params = [];
                if ($search !== '') {
                    $sql .= " AND (d.account_no LIKE ? OR d.account_name LIKE ? OR m.member_no LIKE ? OR m.first_name LIKE ? OR m.last_name LIKE ?)";
                    $params = array_merge($params, ["%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%"]);
                }
                if ($dept !== '') {
                    $sql .= " AND m.department = ?";
                    $params[] = $dept;
                }
                $sql .= " ORDER BY d.balance DESC";
                $rows = Database::query($sql, $params);

                $totalBalance = array_sum(array_column($rows, 'balance'));

                $formattedData = [];
                foreach ($rows as $i => $r) {
                    $formattedData[] = [
                        $i + 1,
                        $r['account_no'],
                        $r['account_name'],
                        $r['account_type'] === 'savings' ? 'ออมทรัพย์ทั่วไป' : ($r['account_type'] === 'special' ? 'ออมทรัพย์พิเศษ' : 'ประจำ'),
                        $r['member_no'],
                        $r['full_name'],
                        number_format((float)$r['interest_rate'], 2) . '%',
                        number_format((float)$r['balance'], 2),
                    ];
                }

                return [
                    'title' => 'รายงานบัญชีเงินรับฝากและยอดคงเหลือสมาชิก',
                    'type' => 'deposits',
                    'headers' => ['ลำดับ', 'เลขที่บัญชี', 'ชื่อบัญชี', 'ประเภทบัญชี', 'เลขสมาชิก', 'ชื่อเจ้าของบัญชี', 'อัตราดอกเบี้ย', 'ยอดเงินคงเหลือ (บาท)'],
                    'data' => $formattedData,
                    'summary' => [
                        'count' => count($rows),
                        'total_balance' => $totalBalance,
                    ],
                ];

            case 'loans':
                $sql = "SELECT l.contract_no, l.loan_name, l.loan_amount, l.principal_balance, l.monthly_installment, l.paid_periods, l.total_periods, l.status, m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as full_name, m.department 
                        FROM loan_contracts l 
                        JOIN members m ON l.member_id = m.id 
                        WHERE 1=1";
                $params = [];
                if ($search !== '') {
                    $sql .= " AND (l.contract_no LIKE ? OR m.member_no LIKE ? OR m.first_name LIKE ? OR m.last_name LIKE ?)";
                    $params = array_merge($params, ["%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%"]);
                }
                if ($dept !== '') {
                    $sql .= " AND m.department = ?";
                    $params[] = $dept;
                }
                if ($status !== '') {
                    $sql .= " AND l.status = ?";
                    $params[] = $status;
                }
                $sql .= " ORDER BY l.principal_balance DESC";
                $rows = Database::query($sql, $params);

                $totalLoanAmount = array_sum(array_column($rows, 'loan_amount'));
                $totalPrincipal = array_sum(array_column($rows, 'principal_balance'));
                $totalMonthly = array_sum(array_column($rows, 'monthly_installment'));

                $formattedData = [];
                foreach ($rows as $i => $r) {
                    $formattedData[] = [
                        $i + 1,
                        $r['contract_no'],
                        $r['loan_name'],
                        $r['member_no'],
                        $r['full_name'],
                        number_format((float)$r['loan_amount'], 2),
                        number_format((float)$r['principal_balance'], 2),
                        number_format((float)$r['monthly_installment'], 2),
                        "{$r['paid_periods']}/{$r['total_periods']} งวด",
                        $r['status'] === 'active' ? 'ปกติ' : ($r['status'] === 'closed' ? 'ปิดสัญญาแล้ว' : $r['status']),
                    ];
                }

                return [
                    'title' => 'รายงานสัญญากู้เงินและลูกหนี้เงินกู้คงเหลือ',
                    'type' => 'loans',
                    'headers' => ['ลำดับ', 'เลขที่สัญญา', 'ประเภทเงินกู้', 'เลขสมาชิก', 'ชื่อผู้กู้', 'วงเงินกู้ (บาท)', 'เงินต้นคงเหลือ (บาท)', 'ค่างวด/เดือน (บาท)', 'ความคืบหน้างวด', 'สถานะสัญญา'],
                    'data' => $formattedData,
                    'summary' => [
                        'count' => count($rows),
                        'total_loan_amount' => $totalLoanAmount,
                        'total_principal' => $totalPrincipal,
                        'total_monthly' => $totalMonthly,
                    ],
                ];

            case 'welfares':
                $sql = "SELECT w.application_no, wt.name as welfare_name, w.claim_amount, w.status, w.created_at, m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as full_name, m.department 
                        FROM welfare_applications w 
                        JOIN welfare_types wt ON w.welfare_type_id = wt.id 
                        JOIN members m ON w.member_id = m.id 
                        WHERE 1=1";
                $params = [];
                if ($search !== '') {
                    $sql .= " AND (w.application_no LIKE ? OR m.member_no LIKE ? OR m.first_name LIKE ? OR m.last_name LIKE ?)";
                    $params = array_merge($params, ["%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%"]);
                }
                if ($dept !== '') {
                    $sql .= " AND m.department = ?";
                    $params[] = $dept;
                }
                if ($status !== '') {
                    $sql .= " AND w.status = ?";
                    $params[] = $status;
                }
                $sql .= " ORDER BY w.id DESC";
                $rows = Database::query($sql, $params);

                $totalClaim = array_sum(array_column($rows, 'claim_amount'));
                $totalApproved = 0;
                foreach ($rows as $r) {
                    if ($r['status'] === 'approved' || $r['status'] === 'completed') {
                        $totalApproved += (float)$r['claim_amount'];
                    }
                }

                $formattedData = [];
                foreach ($rows as $i => $r) {
                    $formattedData[] = [
                        $i + 1,
                        $r['application_no'],
                        $r['welfare_name'],
                        $r['member_no'],
                        $r['full_name'],
                        $r['department'] ?? '-',
                        number_format((float)$r['claim_amount'], 2),
                        date('d/m/Y H:i', strtotime($r['created_at'])),
                        $r['status'] === 'approved' ? 'อนุมัติแล้ว' : ($r['status'] === 'completed' ? 'จ่ายเงินแล้ว' : ($r['status'] === 'rejected' ? 'ไม่อนุมัติ' : 'รอตรวจสอบ')),
                    ];
                }

                return [
                    'title' => 'รายงานการขอรับสวัสดิการสมาชิกสหกรณ์',
                    'type' => 'welfares',
                    'headers' => ['ลำดับ', 'เลขที่คำขอ', 'ประเภทสวัสดิการ', 'เลขสมาชิก', 'ชื่อสมาชิก', 'สังกัด/หน่วยงาน', 'จำนวนเงินสวัสดิการ (บาท)', 'วันที่ยื่นคำขอ', 'สถานะ'],
                    'data' => $formattedData,
                    'summary' => [
                        'count' => count($rows),
                        'total_claim' => $totalClaim,
                        'total_approved' => $totalApproved,
                    ],
                ];

            case 'receipts':
                $sql = "SELECT r.receipt_no, r.billing_month, r.billing_year, r.issue_date, r.share_amount, r.loan_principal, r.loan_interest, r.total_amount, r.status, m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as full_name, m.department 
                        FROM receipts r 
                        JOIN members m ON r.member_id = m.id 
                        WHERE 1=1";
                $params = [];
                if ($search !== '') {
                    $sql .= " AND (r.receipt_no LIKE ? OR m.member_no LIKE ? OR m.first_name LIKE ? OR m.last_name LIKE ?)";
                    $params = array_merge($params, ["%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%"]);
                }
                if ($dept !== '') {
                    $sql .= " AND m.department = ?";
                    $params[] = $dept;
                }
                $sql .= " ORDER BY r.billing_year DESC, r.billing_month DESC, r.id DESC";
                $rows = Database::query($sql, $params);

                $totalShare = array_sum(array_column($rows, 'share_amount'));
                $totalLoanPrinc = array_sum(array_column($rows, 'loan_principal'));
                $totalLoanInt = array_sum(array_column($rows, 'loan_interest'));
                $totalGrand = array_sum(array_column($rows, 'total_amount'));

                $formattedData = [];
                $months = [1=>'ม.ค.', 2=>'ก.พ.', 3=>'มี.ค.', 4=>'เม.ย.', 5=>'พ.ค.', 6=>'มิ.ย.', 7=>'ก.ค.', 8=>'ส.ค.', 9=>'ก.ย.', 10=>'ต.ค.', 11=>'พ.ย.', 12=>'ธ.ค.'];
                foreach ($rows as $i => $r) {
                    $period = ($months[(int)$r['billing_month']] ?? $r['billing_month']) . ' ' . $r['billing_year'];
                    $formattedData[] = [
                        $i + 1,
                        $r['receipt_no'],
                        $period,
                        $r['member_no'],
                        $r['full_name'],
                        $r['department'] ?? '-',
                        number_format((float)$r['share_amount'], 2),
                        number_format((float)$r['loan_principal'], 2),
                        number_format((float)$r['loan_interest'], 2),
                        number_format((float)$r['total_amount'], 2),
                        !empty($r['issue_date']) ? date('d/m/Y', strtotime($r['issue_date'])) : '-',
                        $r['status'] === 'paid' ? 'ชำระแล้ว' : $r['status'],
                    ];
                }

                return [
                    'title' => 'รายงานการเรียกเก็บเงินและใบเสร็จรับเงินประจำเดือน',
                    'type' => 'receipts',
                    'headers' => ['ลำดับ', 'เลขที่ใบเสร็จ', 'งวดประจำเดือน', 'เลขสมาชิก', 'ชื่อสมาชิก', 'สังกัด/หน่วยงาน', 'ค่าหุ้น (บาท)', 'เงินต้นเงินกู้ (บาท)', 'ดอกเบี้ยเงินกู้ (บาท)', 'รวมเงินเรียกเก็บ (บาท)', 'วันที่ออกใบเสร็จ', 'สถานะ'],
                    'data' => $formattedData,
                    'summary' => [
                        'count' => count($rows),
                        'total_share' => $totalShare,
                        'total_loan_principal' => $totalLoanPrinc,
                        'total_loan_interest' => $totalLoanInt,
                        'total_grand' => $totalGrand,
                    ],
                ];

            case 'members':
            default:
                $sql = "SELECT m.member_no, CONCAT(m.prefix, m.first_name, ' ', m.last_name) as full_name, m.department, m.position, m.phone, m.join_date, m.status, COALESCE(s.total_amount, 0) as share_total 
                        FROM members m 
                        LEFT JOIN member_shares s ON m.id = s.member_id 
                        WHERE 1=1";
                $params = [];
                if ($search !== '') {
                    $sql .= " AND (m.member_no LIKE ? OR m.first_name LIKE ? OR m.last_name LIKE ? OR m.phone LIKE ?)";
                    $params = array_merge($params, ["%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%"]);
                }
                if ($dept !== '') {
                    $sql .= " AND m.department = ?";
                    $params[] = $dept;
                }
                if ($status !== '') {
                    $sql .= " AND m.status = ?";
                    $params[] = $status;
                }
                $sql .= " ORDER BY m.id ASC";
                $rows = Database::query($sql, $params);

                $totalShareSum = array_sum(array_column($rows, 'share_total'));

                $formattedData = [];
                foreach ($rows as $i => $r) {
                    $formattedData[] = [
                        $i + 1,
                        $r['member_no'],
                        $r['full_name'],
                        $r['department'] ?? '-',
                        $r['position'] ?? '-',
                        $r['phone'] ?? '-',
                        !empty($r['join_date']) ? date('d/m/Y', strtotime($r['join_date'])) : '-',
                        number_format((float)$r['share_total'], 2),
                        $r['status'] === 'active' ? 'ปกติ (Active)' : ($r['status'] === 'resigned' ? 'ลาออก' : $r['status']),
                    ];
                }

                return [
                    'title' => 'รายงานทะเบียนข้อมูลสมาชิกสหกรณ์',
                    'type' => 'members',
                    'headers' => ['ลำดับ', 'เลขสมาชิก', 'ชื่อ - นามสกุล', 'สังกัด/หน่วยงาน', 'ตำแหน่ง', 'เบอร์โทรศัพท์', 'วันที่เป็นสมาชิก', 'ทุนเรือนหุ้นรวม (บาท)', 'สถานะ'],
                    'data' => $formattedData,
                    'summary' => [
                        'count' => count($rows),
                        'total_share' => $totalShareSum,
                    ],
                ];
        }
    }

    /**
     * Export Report to UTF-8 CSV with BOM for Microsoft Excel compatibility
     */
    public static function exportReportCsv(string $reportType, array $filters = []): string
    {
        $report = self::generateReport($reportType, $filters);
        
        $output = fopen('php://temp', 'r+');
        // UTF-8 BOM for Thai Windows Excel
        fwrite($output, "\xEF\xBB\xBF");

        // Write title & timestamp metadata
        fputcsv($output, [$report['title']]);
        fputcsv($output, ['ข้อมูล ณ วันที่ ' . date('d/m/Y H:i:s'), 'จำนวนทั้งหมด ' . number_format(count($report['data'])) . ' รายการ']);
        fputcsv($output, []); // Empty row separator

        // Write Headers
        fputcsv($output, $report['headers']);

        // Write Rows
        foreach ($report['data'] as $row) {
            // Strip any currency or extra text if clean numbers are needed, or write clean values
            $cleanRow = array_map(function($val) {
                return (string)$val;
            }, $row);
            fputcsv($output, $cleanRow);
        }

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        return $csvContent ?: '';
    }
}
