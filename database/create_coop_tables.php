<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\App;
use App\Core\Database;

$app = new App();
$pdo = Database::connect();

$queries = [
    // 1. Roles: Add member and staff
    "INSERT IGNORE INTO roles (id, name, slug, description, created_at, updated_at) VALUES 
    (12, 'สมาชิกสหกรณ์', 'member', 'สมาชิกสหกรณ์ มีสิทธิ์เข้าใช้งาน Member Portal', NOW(), NOW()),
    (13, 'เจ้าหน้าที่สหกรณ์', 'staff', 'เจ้าหน้าที่สหกรณ์ มีสิทธิ์จัดการข้อมูลและธุรกรรม', NOW(), NOW())",

    // 2. Members table
    "CREATE TABLE IF NOT EXISTS members (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        uuid VARCHAR(36) NOT NULL UNIQUE,
        user_id BIGINT UNSIGNED NULL,
        member_no VARCHAR(20) NOT NULL UNIQUE,
        id_card VARCHAR(20) NOT NULL,
        prefix VARCHAR(20) DEFAULT 'นาย',
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        department VARCHAR(150) NOT NULL,
        position VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        email VARCHAR(100) NOT NULL,
        address TEXT NOT NULL,
        join_date DATE NOT NULL,
        avatar VARCHAR(255) NULL,
        status ENUM('active', 'resigned', 'suspended') DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_member_no (member_no),
        INDEX idx_id_card (id_card)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 3. Member Shares
    "CREATE TABLE IF NOT EXISTS member_shares (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        member_id BIGINT UNSIGNED NOT NULL,
        total_shares INT UNSIGNED NOT NULL DEFAULT 0,
        share_value DECIMAL(15,2) NOT NULL DEFAULT 10.00,
        total_amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
        monthly_share DECIMAL(15,2) NOT NULL DEFAULT 1000.00,
        last_payment_date DATE NULL,
        start_date DATE NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 4. Share Change Requests
    "CREATE TABLE IF NOT EXISTS share_change_requests (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        request_no VARCHAR(30) NOT NULL UNIQUE,
        member_id BIGINT UNSIGNED NOT NULL,
        current_monthly DECIMAL(15,2) NOT NULL,
        requested_monthly DECIMAL(15,2) NOT NULL,
        change_type ENUM('increase', 'decrease') NOT NULL,
        reason TEXT NULL,
        status ENUM('pending', 'approved', 'rejected', 'cancelled') DEFAULT 'pending',
        reviewed_by BIGINT UNSIGNED NULL,
        reviewed_at DATETIME NULL,
        comment TEXT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 5. Deposit Accounts
    "CREATE TABLE IF NOT EXISTS deposit_accounts (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        account_no VARCHAR(20) NOT NULL UNIQUE,
        member_id BIGINT UNSIGNED NOT NULL,
        account_type ENUM('savings', 'special_savings', 'fixed') DEFAULT 'savings',
        account_name VARCHAR(150) NOT NULL,
        balance DECIMAL(15,2) NOT NULL DEFAULT 0.00,
        interest_rate DECIMAL(5,2) NOT NULL DEFAULT 1.50,
        accrued_interest DECIMAL(15,2) NOT NULL DEFAULT 0.00,
        open_date DATE NOT NULL,
        status ENUM('active', 'dormant', 'closed') DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 6. Deposit Transactions
    "CREATE TABLE IF NOT EXISTS deposit_transactions (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        account_id BIGINT UNSIGNED NOT NULL,
        tx_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        tx_type ENUM('deposit', 'withdraw', 'interest', 'transfer_in', 'transfer_out') NOT NULL,
        amount DECIMAL(15,2) NOT NULL,
        balance DECIMAL(15,2) NOT NULL,
        channel VARCHAR(50) DEFAULT 'counter',
        description VARCHAR(255) NULL,
        FOREIGN KEY (account_id) REFERENCES deposit_accounts(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 7. Loan Contracts
    "CREATE TABLE IF NOT EXISTS loan_contracts (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        contract_no VARCHAR(20) NOT NULL UNIQUE,
        member_id BIGINT UNSIGNED NOT NULL,
        loan_type ENUM('emergency', 'ordinary', 'special') NOT NULL,
        loan_name VARCHAR(100) NOT NULL,
        loan_amount DECIMAL(15,2) NOT NULL,
        principal_balance DECIMAL(15,2) NOT NULL,
        interest_rate DECIMAL(5,2) NOT NULL DEFAULT 4.75,
        monthly_installment DECIMAL(15,2) NOT NULL,
        total_periods INT UNSIGNED NOT NULL,
        paid_periods INT UNSIGNED NOT NULL DEFAULT 0,
        remaining_periods INT UNSIGNED NOT NULL,
        start_date DATE NOT NULL,
        due_date DATE NOT NULL,
        status ENUM('active', 'paid_off', 'defaulted') DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 8. Loan Amortization Schedules
    "CREATE TABLE IF NOT EXISTS loan_amortization_schedules (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        loan_id BIGINT UNSIGNED NOT NULL,
        period_no INT UNSIGNED NOT NULL,
        due_date DATE NOT NULL,
        principal_payment DECIMAL(15,2) NOT NULL,
        interest_payment DECIMAL(15,2) NOT NULL,
        total_payment DECIMAL(15,2) NOT NULL,
        remaining_principal DECIMAL(15,2) NOT NULL,
        paid_status ENUM('paid', 'pending', 'overdue') DEFAULT 'pending',
        paid_at DATETIME NULL,
        FOREIGN KEY (loan_id) REFERENCES loan_contracts(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 9. Loan Applications (Online Wizard)
    "CREATE TABLE IF NOT EXISTS loan_applications (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        application_no VARCHAR(30) NOT NULL UNIQUE,
        member_id BIGINT UNSIGNED NOT NULL,
        loan_type ENUM('emergency', 'ordinary', 'special') NOT NULL,
        request_amount DECIMAL(15,2) NOT NULL,
        request_term INT UNSIGNED NOT NULL,
        estimated_monthly DECIMAL(15,2) NOT NULL,
        salary DECIMAL(15,2) NOT NULL,
        purpose TEXT NOT NULL,
        guarantor_member_no VARCHAR(20) NULL,
        documents_json LONGTEXT NULL,
        status ENUM('draft', 'submitted', 'document_review', 'staff_review', 'approved', 'rejected', 'cancelled', 'completed') DEFAULT 'submitted',
        current_step INT UNSIGNED DEFAULT 1,
        staff_comment TEXT NULL,
        approved_by BIGINT UNSIGNED NULL,
        approved_at DATETIME NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 10. Welfare Benefits & Applications
    "CREATE TABLE IF NOT EXISTS welfare_types (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(150) NOT NULL,
        category VARCHAR(100) NOT NULL,
        coverage_amount DECIMAL(15,2) NOT NULL,
        conditions TEXT NOT NULL,
        icon VARCHAR(50) DEFAULT 'bi-heart-pulse',
        status ENUM('active', 'inactive') DEFAULT 'active'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    "CREATE TABLE IF NOT EXISTS welfare_applications (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        application_no VARCHAR(30) NOT NULL UNIQUE,
        member_id BIGINT UNSIGNED NOT NULL,
        welfare_type_id BIGINT UNSIGNED NOT NULL,
        claim_amount DECIMAL(15,2) NOT NULL,
        description TEXT NOT NULL,
        documents_json LONGTEXT NULL,
        status ENUM('pending', 'under_review', 'approved', 'rejected', 'completed') DEFAULT 'pending',
        reviewed_by BIGINT UNSIGNED NULL,
        reviewed_at DATETIME NULL,
        comment TEXT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
        FOREIGN KEY (welfare_type_id) REFERENCES welfare_types(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 11. Beneficiaries
    "CREATE TABLE IF NOT EXISTS beneficiaries (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        member_id BIGINT UNSIGNED NOT NULL,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        relationship VARCHAR(50) NOT NULL,
        id_card_masked VARCHAR(20) NOT NULL,
        percentage DECIMAL(5,2) NOT NULL DEFAULT 100.00,
        phone VARCHAR(20) NOT NULL,
        priority_order INT UNSIGNED DEFAULT 1,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 12. Receipts
    "CREATE TABLE IF NOT EXISTS receipts (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        receipt_no VARCHAR(30) NOT NULL UNIQUE,
        member_id BIGINT UNSIGNED NOT NULL,
        billing_month INT NOT NULL,
        billing_year INT NOT NULL,
        issue_date DATE NOT NULL,
        share_amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
        loan_principal DECIMAL(15,2) NOT NULL DEFAULT 0.00,
        loan_interest DECIMAL(15,2) NOT NULL DEFAULT 0.00,
        deposit_amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
        other_amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
        total_amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
        qr_verify_token VARCHAR(64) NOT NULL,
        status ENUM('paid', 'cancelled', 'refunded') DEFAULT 'paid',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 13. Notifications
    "CREATE TABLE IF NOT EXISTS notifications (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT UNSIGNED NULL,
        member_id BIGINT UNSIGNED NULL,
        title VARCHAR(200) NOT NULL,
        message TEXT NOT NULL,
        type ENUM('receipt', 'billing', 'loan_approval', 'doc_request', 'request_status', 'news', 'welfare', 'system') NOT NULL,
        link_url VARCHAR(255) NULL,
        is_read TINYINT(1) NOT NULL DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_member_notify (member_id, is_read)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 14. Online General Requests
    "CREATE TABLE IF NOT EXISTS online_requests (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        request_no VARCHAR(30) NOT NULL UNIQUE,
        member_id BIGINT UNSIGNED NOT NULL,
        request_type ENUM('loan', 'share_change', 'welfare', 'certificate', 'statement', 'debt_cert', 'contact_staff', 'other') NOT NULL,
        title VARCHAR(200) NOT NULL,
        details TEXT NOT NULL,
        documents_json LONGTEXT NULL,
        status ENUM('submitted', 'in_progress', 'completed', 'rejected', 'cancelled') DEFAULT 'submitted',
        assigned_to BIGINT UNSIGNED NULL,
        timeline_json LONGTEXT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 15. Login Activities
    "CREATE TABLE IF NOT EXISTS login_activities (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT UNSIGNED NOT NULL,
        ip_address VARCHAR(45) NOT NULL,
        device VARCHAR(100) NOT NULL,
        browser VARCHAR(100) NOT NULL,
        status ENUM('success', 'failed') DEFAULT 'success',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // 16. LINE Connections
    "CREATE TABLE IF NOT EXISTS line_connections (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        member_id BIGINT UNSIGNED NOT NULL UNIQUE,
        line_user_id VARCHAR(100) NULL,
        display_name VARCHAR(150) NULL,
        status ENUM('connected', 'disconnected') DEFAULT 'disconnected',
        notify_billing TINYINT(1) DEFAULT 1,
        notify_receipt TINYINT(1) DEFAULT 1,
        notify_loan TINYINT(1) DEFAULT 1,
        notify_news TINYINT(1) DEFAULT 1,
        connected_at DATETIME NULL,
        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];

foreach ($queries as $sql) {
    try {
        $pdo->exec($sql);
    } catch (\Throwable $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "All cooperative tables verified / created successfully!\n";
