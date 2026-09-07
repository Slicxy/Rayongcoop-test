<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\App;
use App\Core\Database;

$app = new App();
$pdo = Database::connect();

// 1. Ensure Roles exist
$roles = [
    ['id' => 1, 'name' => 'Super Admin', 'slug' => 'super_admin'],
    ['id' => 12, 'name' => 'สมาชิกสหกรณ์', 'slug' => 'member'],
    ['id' => 13, 'name' => 'เจ้าหน้าที่สหกรณ์', 'slug' => 'staff'],
];

foreach ($roles as $r) {
    Database::execute("INSERT INTO roles (id, name, slug, description, created_at, updated_at) 
        VALUES (?, ?, ?, 'Role description', NOW(), NOW()) 
        ON DUPLICATE KEY UPDATE name = VALUES(name)", [$r['id'], $r['name'], $r['slug']]);
}

// 2. Create Users
$users = [
    [
        'username' => 'rayongcoop1',
        'email' => 'rayongcoop1@rayongcoop.com',
        'password' => password_hash('coop1', PASSWORD_DEFAULT),
        'name' => 'นายสมชาย มีสุข',
        'role_id' => 12, // member
    ],
    [
        'username' => 'staff1',
        'email' => 'staff1@rayongcoop.com',
        'password' => password_hash('staff123', PASSWORD_DEFAULT),
        'name' => 'นางสาวกานดา ใจดี (เจ้าหน้าที่สินเชื่อ)',
        'role_id' => 13, // staff
    ],
    [
        'username' => 'admin',
        'email' => 'admin@rayongcoop.com',
        'password' => password_hash('Admin@RayongCoop2026!', PASSWORD_DEFAULT),
        'name' => 'ผู้ดูแลระบบสูงสุด (Super Admin)',
        'role_id' => 1, // super_admin
    ]
];

foreach ($users as $u) {
    $existing = Database::first("SELECT id FROM users WHERE username = ?", [$u['username']]);
    if (!$existing) {
        $userId = Database::insert(
            "INSERT INTO users (uuid, name, username, email, password, status, two_factor_enabled, created_at, updated_at) VALUES (?, ?, ?, ?, ?, 'active', 0, NOW(), NOW())",
            [
                'usr-' . uniqid(),
                $u['name'],
                $u['username'],
                $u['email'],
                $u['password'],
            ]
        );
        if ($userId) {
            Database::execute("INSERT IGNORE INTO user_roles (user_id, role_id) VALUES (?, ?)", [(int)$userId, $u['role_id']]);
        }
    } else {
        Database::execute("UPDATE users SET password = ?, status = 'active', two_factor_enabled = 0 WHERE id = ?", [$u['password'], $existing['id']]);
        Database::execute("INSERT IGNORE INTO user_roles (user_id, role_id) VALUES (?, ?)", [$existing['id'], $u['role_id']]);
    }
}

// Get user ID for rayongcoop1
$mainUser = Database::first("SELECT id FROM users WHERE username = 'rayongcoop1'");
$mainUserId = $mainUser ? (int)$mainUser['id'] : null;

// 3. Seed 5 Members
$membersData = [
    [
        'member_no' => 'MEM-2024-0001',
        'user_id' => $mainUserId,
        'id_card' => '1219900123456',
        'prefix' => 'นาย',
        'first_name' => 'สมชาย',
        'last_name' => 'มีสุข',
        'department' => 'กลุ่มงานการพยาบาล โรงพยาบาลระยอง',
        'position' => 'พยาบาลวิชาชีพชำนาญการ',
        'phone' => '081-234-5678',
        'email' => 'somchai.m@rayongcoop.com',
        'address' => '123/45 หมู่ 2 ต.เชิงเนิน อ.เมือง จ.ระยอง 21000',
        'join_date' => '2018-05-15',
    ],
    [
        'member_no' => 'MEM-2024-0002',
        'user_id' => null,
        'id_card' => '3219900876543',
        'prefix' => 'นาง',
        'first_name' => 'วิภาดา',
        'last_name' => 'รุ่งเรืองทรัพย์',
        'department' => 'สำนักงานสาธารณสุขอำเภอบ้านฉาง',
        'position' => 'นักวิชาการสาธารณสุขชำนาญการ',
        'phone' => '089-876-5432',
        'email' => 'wiphada.r@rayongcoop.com',
        'address' => '88/12 หมู่ 5 ต.บ้านฉาง อ.บ้านฉาง จ.ระยอง 21130',
        'join_date' => '2019-02-10',
    ],
    [
        'member_no' => 'MEM-2024-0003',
        'user_id' => null,
        'id_card' => '1219900554433',
        'prefix' => 'นาย',
        'first_name' => 'ธีรศักดิ์',
        'last_name' => 'มั่งคั่ง',
        'department' => 'โรงพยาบาลแกลง',
        'position' => 'เจ้าพนักงานเภสัชกรรมชำนาญงาน',
        'phone' => '086-555-4321',
        'email' => 'theerasak.m@rayongcoop.com',
        'address' => '45/8 ถ.สุขุมวิท ต.ทางเกวียน อ.แกลง จ.ระยอง 21110',
        'join_date' => '2020-08-01',
    ],
    [
        'member_no' => 'MEM-2024-0004',
        'user_id' => null,
        'id_card' => '3219900998877',
        'prefix' => 'นางสาว',
        'first_name' => 'พิมพาพร',
        'last_name' => 'ทองเจริญ',
        'department' => 'สำนักงานสาธารณสุขจังหวัดระยอง',
        'position' => 'นักจัดการงานทั่วไปปฏิบัติการ',
        'phone' => '082-999-1122',
        'email' => 'pimpaporn.t@rayongcoop.com',
        'address' => '99/4 ต.เนินพระ อ.เมือง จ.ระยอง 21000',
        'join_date' => '2021-11-20',
    ],
    [
        'member_no' => 'MEM-2024-0005',
        'user_id' => null,
        'id_card' => '1219900776655',
        'prefix' => 'นาย',
        'first_name' => 'ณัฐนนท์',
        'last_name' => 'เจริญสุข',
        'department' => 'โรงพยาบาลปลวกแดง',
        'position' => 'นายแพทย์ชำนาญการ',
        'phone' => '085-333-7788',
        'email' => 'nathanon.c@rayongcoop.com',
        'address' => '12/3 ต.ปลวกแดง อ.ปลวกแดง จ.ระยอง 21140',
        'join_date' => '2017-03-12',
    ],
];

$seededMemberIds = [];

foreach ($membersData as $m) {
    $existing = Database::first("SELECT id FROM members WHERE member_no = ?", [$m['member_no']]);
    if (!$existing) {
        $mId = Database::insert(
            "INSERT INTO members (uuid, user_id, member_no, id_card, prefix, first_name, last_name, department, position, phone, email, address, join_date, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')",
            [
                'mem-' . uniqid(),
                $m['user_id'],
                $m['member_no'],
                $m['id_card'],
                $m['prefix'],
                $m['first_name'],
                $m['last_name'],
                $m['department'],
                $m['position'],
                $m['phone'],
                $m['email'],
                $m['address'],
                $m['join_date']
            ]
        );
        $seededMemberIds[$m['member_no']] = (int)$mId;
    } else {
        if ($m['user_id']) {
            Database::execute("UPDATE members SET user_id = ? WHERE id = ?", [$m['user_id'], $existing['id']]);
        }
        $seededMemberIds[$m['member_no']] = (int)$existing['id'];
    }
}

$targetMemberId = $seededMemberIds['MEM-2024-0001'] ?? 1;

// 4. Seed Member Shares for target member
$existingShare = Database::first("SELECT id FROM member_shares WHERE member_id = ?", [$targetMemberId]);
if (!$existingShare) {
    Database::insert(
        "INSERT INTO member_shares (member_id, total_shares, share_value, total_amount, monthly_share, last_payment_date, start_date) 
         VALUES (?, 24500, 10.00, 245000.00, 1500.00, '2026-08-31', '2018-05-15')",
        [$targetMemberId]
    );
}

// 5. Seed Deposit Accounts
$depositAccounts = [
    [
        'account_no' => '01-00892-4',
        'account_type' => 'savings',
        'account_name' => 'เงินฝากออมทรัพย์ทั่วไป (นายสมชาย มีสุข)',
        'balance' => 85400.50,
        'interest_rate' => 1.50,
        'accrued_interest' => 640.25,
        'open_date' => '2018-06-01'
    ],
    [
        'account_no' => '02-00341-9',
        'account_type' => 'special_savings',
        'account_name' => 'เงินฝากออมทรัพย์พิเศษทวีโชค',
        'balance' => 250000.00,
        'interest_rate' => 2.75,
        'accrued_interest' => 3437.50,
        'open_date' => '2020-01-15'
    ]
];

foreach ($depositAccounts as $acc) {
    $existing = Database::first("SELECT id FROM deposit_accounts WHERE account_no = ?", [$acc['account_no']]);
    if (!$existing) {
        $accId = Database::insert(
            "INSERT INTO deposit_accounts (account_no, member_id, account_type, account_name, balance, interest_rate, accrued_interest, open_date, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active')",
            [
                $acc['account_no'],
                $targetMemberId,
                $acc['account_type'],
                $acc['account_name'],
                $acc['balance'],
                $acc['interest_rate'],
                $acc['accrued_interest'],
                $acc['open_date']
            ]
        );

        // Seed Transactions
        if ($accId) {
            Database::insert("INSERT INTO deposit_transactions (account_id, tx_date, tx_type, amount, balance, channel, description) VALUES (?, '2026-08-31 09:30:00', 'deposit', 5000.00, 85400.50, 'หักเงินเดือน', 'เงินฝากสะสมประจำงวด')", [(int)$accId]);
            Database::insert("INSERT INTO deposit_transactions (account_id, tx_date, tx_type, amount, balance, channel, description) VALUES (?, '2026-07-31 10:15:00', 'deposit', 5000.00, 80400.50, 'หักเงินเดือน', 'เงินฝากสะสมประจำงวด')", [(int)$accId]);
            Database::insert("INSERT INTO deposit_transactions (account_id, tx_date, tx_type, amount, balance, channel, description) VALUES (?, '2026-06-30 14:00:00', 'interest', 540.25, 75400.50, 'ระบบอัตโนมัติ', 'ดอกเบี้ยเงินฝากประจำงวด 6 เดือน')", [(int)$accId]);
            Database::insert("INSERT INTO deposit_transactions (account_id, tx_date, tx_type, amount, balance, channel, description) VALUES (?, '2026-06-15 11:20:00', 'withdraw', 10000.00, 74860.25, 'เคาน์เตอร์สหกรณ์', 'ถอนเงินสด')", [(int)$accId]);
        }
    }
}

// 6. Seed Loan Contracts
$loans = [
    [
        'contract_no' => 'LN-67-00142',
        'loan_type' => 'ordinary',
        'loan_name' => 'เงินกู้สามัญเพื่อพัฒนาคุณภาพชีวิต',
        'loan_amount' => 500000.00,
        'principal_balance' => 345000.00,
        'interest_rate' => 4.75,
        'monthly_installment' => 7850.00,
        'total_periods' => 84,
        'paid_periods' => 26,
        'remaining_periods' => 58,
        'start_date' => '2024-06-30',
        'due_date' => '2031-05-31'
    ],
    [
        'contract_no' => 'LN-68-00089',
        'loan_type' => 'emergency',
        'loan_name' => 'เงินกู้ฉุกเฉินเพื่อเหตุจำเป็นเร่งด่วน',
        'loan_amount' => 50000.00,
        'principal_balance' => 12500.00,
        'interest_rate' => 5.25,
        'monthly_installment' => 4350.00,
        'total_periods' => 12,
        'paid_periods' => 9,
        'remaining_periods' => 3,
        'start_date' => '2025-11-30',
        'due_date' => '2026-10-31'
    ]
];

foreach ($loans as $ln) {
    $existing = Database::first("SELECT id FROM loan_contracts WHERE contract_no = ?", [$ln['contract_no']]);
    if (!$existing) {
        $loanId = Database::insert(
            "INSERT INTO loan_contracts (contract_no, member_id, loan_type, loan_name, loan_amount, principal_balance, interest_rate, monthly_installment, total_periods, paid_periods, remaining_periods, start_date, due_date, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')",
            [
                $ln['contract_no'],
                $targetMemberId,
                $ln['loan_type'],
                $ln['loan_name'],
                $ln['loan_amount'],
                $ln['principal_balance'],
                $ln['interest_rate'],
                $ln['monthly_installment'],
                $ln['total_periods'],
                $ln['paid_periods'],
                $ln['remaining_periods'],
                $ln['start_date'],
                $ln['due_date']
            ]
        );

        if ($loanId) {
            // Seed amortization sample
            for ($p = 1; $p <= 12; $p++) {
                $status = $p <= $ln['paid_periods'] ? 'paid' : 'pending';
                $pDate = date('Y-m-d', strtotime("+{$p} month", strtotime($ln['start_date'])));
                Database::insert(
                    "INSERT INTO loan_amortization_schedules (loan_id, period_no, due_date, principal_payment, interest_payment, total_payment, remaining_principal, paid_status) 
                     VALUES (?, ?, ?, 5500.00, 2350.00, 7850.00, ?, ?)",
                    [(int)$loanId, $p, $pDate, max(0, $ln['loan_amount'] - ($p * 5500)), $status]
                );
            }
        }
    }
}

// 7. Seed Welfare Types & Applications
$welfares = [
    ['name' => 'เงินสงเคราะห์สมาชิกถึงแก่กรรม', 'category' => 'สวัสดิการคุ้มครอง', 'coverage_amount' => 300000.00, 'conditions' => 'เป็นสมาชิกต่อเนื่องไม่น้อยกว่า 1 ปี', 'icon' => 'bi-shield-shaded'],
    ['name' => 'ทุนการศึกษาบุตรสมาชิกประจำปี', 'category' => 'สวัสดิการการศึกษา', 'coverage_amount' => 5000.00, 'conditions' => 'บุตรกำลังศึกษาในระดับประถม-อุดมศึกษา เกรดเฉลี่ย >= 3.00', 'icon' => 'bi-mortarboard-fill'],
    ['name' => 'สวัสดิการคลอดบุตรและสงเคราะห์บุตร', 'category' => 'สวัสดิการครอบครัว', 'coverage_amount' => 3000.00, 'conditions' => 'มอบให้ต่อการคลอดบุตร 1 คน พร้อมยื่นสูติบัตร', 'icon' => 'bi-heart-fill'],
    ['name' => 'สวัสดิการกรณีเจ็บป่วยนอนพักรักษาตัว', 'category' => 'สวัสดิการสุขภาพ', 'coverage_amount' => 1000.00, 'conditions' => 'คืนละ 500 บาท สูงสุดไม่เกิน 20 คืนต่อปี', 'icon' => 'bi-hospital-fill'],
];

foreach ($welfares as $wf) {
    $existing = Database::first("SELECT id FROM welfare_types WHERE name = ?", [$wf['name']]);
    if (!$existing) {
        Database::insert(
            "INSERT INTO welfare_types (name, category, coverage_amount, conditions, icon, status) VALUES (?, ?, ?, ?, ?, 'active')",
            [$wf['name'], $wf['category'], $wf['coverage_amount'], $wf['conditions'], $wf['icon']]
        );
    }
}

// 8. Seed Beneficiaries for member (sums to 100%)
$beneficiaries = [
    ['first_name' => 'นางวรรณา', 'last_name' => 'มีสุข', 'relationship' => 'คู่สมรส', 'id_card_masked' => '3-2199-XXXXX-12-1', 'percentage' => 70.00, 'phone' => '089-111-2233', 'priority_order' => 1],
    ['first_name' => 'ด.ช.ธนกฤต', 'last_name' => 'มีสุข', 'relationship' => 'บุตร', 'id_card_masked' => '1-2199-XXXXX-88-9', 'percentage' => 30.00, 'phone' => '081-234-5678', 'priority_order' => 2],
];

foreach ($beneficiaries as $b) {
    $existing = Database::first("SELECT id FROM beneficiaries WHERE member_id = ? AND first_name = ?", [$targetMemberId, $b['first_name']]);
    if (!$existing) {
        Database::insert(
            "INSERT INTO beneficiaries (member_id, first_name, last_name, relationship, id_card_masked, percentage, phone, priority_order, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active')",
            [$targetMemberId, $b['first_name'], $b['last_name'], $b['relationship'], $b['id_card_masked'], $b['percentage'], $b['phone'], $b['priority_order']]
        );
    }
}

// 9. Seed Receipts
$receipts = [
    [
        'receipt_no' => 'RCP-2569-08-00412',
        'billing_month' => 8,
        'billing_year' => 2569,
        'issue_date' => '2026-08-31',
        'share_amount' => 1500.00,
        'loan_principal' => 5500.00,
        'loan_interest' => 2350.00,
        'deposit_amount' => 5000.00,
        'other_amount' => 100.00,
        'total_amount' => 14450.00,
        'qr_verify_token' => hash('sha256', 'RCP-2569-08-00412-MEM-2024-0001')
    ],
    [
        'receipt_no' => 'RCP-2569-07-00398',
        'billing_month' => 7,
        'billing_year' => 2569,
        'issue_date' => '2026-07-31',
        'share_amount' => 1500.00,
        'loan_principal' => 5500.00,
        'loan_interest' => 2390.00,
        'deposit_amount' => 5000.00,
        'other_amount' => 100.00,
        'total_amount' => 14490.00,
        'qr_verify_token' => hash('sha256', 'RCP-2569-07-00398-MEM-2024-0001')
    ],
    [
        'receipt_no' => 'RCP-2569-06-00385',
        'billing_month' => 6,
        'billing_year' => 2569,
        'issue_date' => '2026-06-30',
        'share_amount' => 1500.00,
        'loan_principal' => 5500.00,
        'loan_interest' => 2430.00,
        'deposit_amount' => 5000.00,
        'other_amount' => 100.00,
        'total_amount' => 14530.00,
        'qr_verify_token' => hash('sha256', 'RCP-2569-06-00385-MEM-2024-0001')
    ]
];

foreach ($receipts as $rcp) {
    $existing = Database::first("SELECT id FROM receipts WHERE receipt_no = ?", [$rcp['receipt_no']]);
    if (!$existing) {
        Database::insert(
            "INSERT INTO receipts (receipt_no, member_id, billing_month, billing_year, issue_date, share_amount, loan_principal, loan_interest, deposit_amount, other_amount, total_amount, qr_verify_token, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'paid')",
            [
                $rcp['receipt_no'],
                $targetMemberId,
                $rcp['billing_month'],
                $rcp['billing_year'],
                $rcp['issue_date'],
                $rcp['share_amount'],
                $rcp['loan_principal'],
                $rcp['loan_interest'],
                $rcp['deposit_amount'],
                $rcp['other_amount'],
                $rcp['total_amount'],
                $rcp['qr_verify_token']
            ]
        );
    }
}

// 10. Seed Notifications
$notifications = [
    [
        'title' => 'ใบเสร็จรับเงินประจำเดือนสิงหาคม 2569',
        'message' => 'สหกรณ์ได้ออกใบเสร็จรับเงินเลขที่ RCP-2569-08-00412 ยอดชำระ 14,450.00 บาท เรียบร้อยแล้ว',
        'type' => 'receipt',
        'link_url' => '/member/receipts',
        'is_read' => 0
    ],
    [
        'title' => 'แจ้งยอดเรียกเก็บประจำเดือนกันยายน 2569',
        'message' => 'ยอดหักประจำงวดเดือน ก.ย. 2569 รวมทั้งสิ้น 14,450.00 บาท (ค่าหุ้น, เงินกู้, เงินฝาก)',
        'type' => 'billing',
        'link_url' => '/member/dashboard',
        'is_read' => 0
    ],
    [
        'title' => 'คำขอกู้เงินฉุกเฉินได้รับการอนุมัติ',
        'message' => 'สัญญาเงินกู้เลขที่ LN-68-00089 วงเงิน 50,000.00 บาท ได้รับการโอนเข้าบัญชีออมทรัพย์แล้ว',
        'type' => 'loan_approval',
        'link_url' => '/member/loans',
        'is_read' => 1
    ]
];

foreach ($notifications as $nt) {
    $existing = Database::first("SELECT id FROM notifications WHERE member_id = ? AND title = ?", [$targetMemberId, $nt['title']]);
    if (!$existing) {
        Database::insert(
            "INSERT INTO notifications (user_id, member_id, title, message, type, link_url, is_read, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())",
            [$mainUserId, $targetMemberId, $nt['title'], $nt['message'], $nt['type'], $nt['link_url'], $nt['is_read']]
        );
    }
}

// 11. Seed Online Requests
$requests = [
    [
        'request_no' => 'REQ-2026-00012',
        'request_type' => 'share_change',
        'title' => 'คำขอเปลี่ยนแปลงอัตราส่งค่าหุ้นรายเดือน',
        'details' => 'ขอปรับเพิ่มเงินส่งค่าหุ้นจาก 1,000 บาท เป็น 1,500 บาทต่อเดือน',
        'status' => 'completed',
        'timeline_json' => json_encode([
            ['status' => 'submitted', 'time' => '2026-08-01 10:00', 'desc' => 'สมาชิกยื่นคำขอผ่านระบบ'],
            ['status' => 'in_progress', 'time' => '2026-08-02 14:30', 'desc' => 'เจ้าหน้าที่ตรวจสอบเอกสารและส่งต่อฝ่ายบัญชี'],
            ['status' => 'completed', 'time' => '2026-08-05 09:00', 'desc' => 'อนุมัติเรียบร้อย มีผลบังคับใช้งวด ส.ค. 2569']
        ])
    ],
    [
        'request_no' => 'REQ-2026-00045',
        'request_type' => 'certificate',
        'title' => 'ขอหนังสือรับรองการเป็นสมาชิกและยอดหุ้น',
        'details' => 'เพื่อใช้ประกอบการยื่นขอวีซ่าท่องเที่ยว',
        'status' => 'in_progress',
        'timeline_json' => json_encode([
            ['status' => 'submitted', 'time' => '2026-09-02 11:20', 'desc' => 'ยื่นคำขอเรียบร้อย'],
            ['status' => 'in_progress', 'time' => '2026-09-03 09:00', 'desc' => 'กำลังจัดพิมพ์เอกสารและลงนาม']
        ])
    ]
];

foreach ($requests as $rq) {
    $existing = Database::first("SELECT id FROM online_requests WHERE request_no = ?", [$rq['request_no']]);
    if (!$existing) {
        Database::insert(
            "INSERT INTO online_requests (request_no, member_id, request_type, title, details, status, timeline_json, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())",
            [$rq['request_no'], $targetMemberId, $rq['request_type'], $rq['title'], $rq['details'], $rq['status'], $rq['timeline_json']]
        );
    }
}

// 12. Seed Login Activities
$loginActs = [
    ['ip_address' => '125.25.14.88', 'device' => 'Windows PC (Desktop)', 'browser' => 'Google Chrome 128.0', 'status' => 'success'],
    ['ip_address' => '171.96.22.10', 'device' => 'iPhone 15 Pro (Mobile)', 'browser' => 'Safari Mobile 17.5', 'status' => 'success'],
    ['ip_address' => '125.25.14.88', 'device' => 'Windows PC (Desktop)', 'browser' => 'Google Chrome 128.0', 'status' => 'success']
];

foreach ($loginActs as $la) {
    Database::insert(
        "INSERT INTO login_activities (user_id, ip_address, device, browser, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())",
        [$mainUserId, $la['ip_address'], $la['device'], $la['browser'], $la['status']]
    );
}

// 13. Seed LINE Connection
$existingLine = Database::first("SELECT id FROM line_connections WHERE member_id = ?", [$targetMemberId]);
if (!$existingLine) {
    Database::insert(
        "INSERT INTO line_connections (member_id, line_user_id, display_name, status, notify_billing, notify_receipt, notify_loan, notify_news, connected_at) 
         VALUES (?, 'U1a2b3c4d5e6f7g8h9', 'Somchai MeeSook', 'connected', 1, 1, 1, 1, '2026-01-10 14:20:00')",
        [$targetMemberId]
    );
}

echo "Cooperative test data seeded successfully!\n";
