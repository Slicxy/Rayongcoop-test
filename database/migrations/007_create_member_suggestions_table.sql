-- Migration: 007_create_member_suggestions_table.sql
-- Description: Create member_suggestions table for Member Voice & Suggestion Box

CREATE TABLE IF NOT EXISTS `member_suggestions` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `suggestion_no` VARCHAR(30) NOT NULL UNIQUE,
    `member_id` BIGINT(20) UNSIGNED NOT NULL,
    `category` ENUM('service', 'loan', 'welfare', 'technology', 'general') NOT NULL DEFAULT 'general',
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `attachment_path` VARCHAR(255) NULL DEFAULT NULL,
    `is_anonymous` TINYINT(1) NOT NULL DEFAULT 0,
    `status` ENUM('submitted', 'under_review', 'approved', 'implemented', 'declined') NOT NULL DEFAULT 'submitted',
    `admin_response` TEXT NULL DEFAULT NULL,
    `responded_by` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `responded_at` DATETIME NULL DEFAULT NULL,
    `likes_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_suggestions_member` (`member_id`),
    INDEX `idx_suggestions_status_cat` (`status`, `category`),
    CONSTRAINT `fk_suggestions_member` FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
