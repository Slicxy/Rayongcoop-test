-- Migration: 005_create_tax_certificates_table.sql
-- Description: Create tax_certificates table for housing loan interest deduction certificates

CREATE TABLE IF NOT EXISTS `tax_certificates` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `certificate_no` VARCHAR(50) NOT NULL UNIQUE,
    `member_id` BIGINT(20) UNSIGNED NOT NULL,
    `tax_year` INT(11) NOT NULL,
    `thai_year` INT(11) NOT NULL,
    `contract_no` VARCHAR(50) NOT NULL,
    `loan_type` VARCHAR(150) NOT NULL DEFAULT 'เงินกู้พิเศษเพื่อการเคหะ',
    `borrower_name` VARCHAR(200) NOT NULL,
    `id_card_no` VARCHAR(20) NULL DEFAULT NULL,
    `co_borrower_name` VARCHAR(200) NULL DEFAULT NULL,
    `property_address` TEXT NULL DEFAULT NULL,
    `total_interest_paid` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `total_principal_paid` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `total_paid` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `interest_baht_text` VARCHAR(255) NOT NULL DEFAULT '',
    `monthly_breakdown` JSON NULL DEFAULT NULL,
    `qr_verify_token` VARCHAR(64) NOT NULL UNIQUE,
    `issue_date` DATE NOT NULL,
    `status` ENUM('issued', 'revoked') NOT NULL DEFAULT 'issued',
    `created_by` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_tax_cert_member_year` (`member_id`, `tax_year`),
    INDEX `idx_tax_cert_contract` (`contract_no`),
    INDEX `idx_tax_cert_token` (`qr_verify_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
