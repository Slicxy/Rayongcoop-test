-- Migration: 002_create_contact_messages_table.sql
-- Description: Create contact_messages table for storing and managing member/public inquiries

CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(50) NULL DEFAULT NULL,
    `email` VARCHAR(150) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `status` ENUM('new', 'in_progress', 'answered', 'closed') NOT NULL DEFAULT 'new',
    `staff_notes` TEXT NULL DEFAULT NULL,
    `staff_reply` TEXT NULL DEFAULT NULL,
    `responded_by` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `responded_at` DATETIME NULL DEFAULT NULL,
    `ip_address` VARCHAR(45) NULL DEFAULT NULL,
    `user_agent` VARCHAR(255) NULL DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_contact_status` (`status`),
    INDEX `idx_contact_created_at` (`created_at`),
    INDEX `idx_contact_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
