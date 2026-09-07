-- Migration: 003_create_important_announcements_table.sql
-- Description: Create or enhance important announcements structure

CREATE TABLE IF NOT EXISTS `important_announcements` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `content` LONGTEXT NOT NULL,
    `summary` TEXT NULL DEFAULT NULL,
    `attachment_path` VARCHAR(255) NULL DEFAULT NULL,
    `attachment_name` VARCHAR(255) NULL DEFAULT NULL,
    `publication_date` DATE NOT NULL,
    `effective_start_date` DATE NULL DEFAULT NULL,
    `expiry_date` DATE NULL DEFAULT NULL,
    `priority` ENUM('urgent', 'important', 'general') NOT NULL DEFAULT 'general',
    `resolution_no` VARCHAR(100) NULL DEFAULT NULL,
    `related_link` VARCHAR(255) NULL DEFAULT NULL,
    `status` ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'published',
    `is_pinned` TINYINT(1) NOT NULL DEFAULT 0,
    `view_count` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
    `created_by` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `updated_by` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_announcement_slug` (`slug`),
    INDEX `idx_announcement_status_date` (`status`, `publication_date`, `expiry_date`),
    INDEX `idx_announcement_priority` (`priority`, `is_pinned`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
