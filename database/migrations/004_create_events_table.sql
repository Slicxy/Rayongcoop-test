-- Migration: 004_create_events_table.sql
-- Description: Create events table for cooperative calendar and schedule

CREATE TABLE IF NOT EXISTS `events` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `category` ENUM('meeting', 'loan_window', 'dividend', 'holiday', 'activity', 'other') NOT NULL DEFAULT 'activity',
    `start_date` DATE NOT NULL,
    `end_date` DATE NULL DEFAULT NULL,
    `start_time` TIME NULL DEFAULT NULL,
    `end_time` TIME NULL DEFAULT NULL,
    `location` VARCHAR(255) NULL DEFAULT NULL,
    `related_link` VARCHAR(255) NULL DEFAULT NULL,
    `status` ENUM('upcoming', 'completed', 'cancelled') NOT NULL DEFAULT 'upcoming',
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
    `sort_order` INT(11) NOT NULL DEFAULT 0,
    `created_by` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `updated_by` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_event_slug` (`slug`),
    INDEX `idx_event_dates` (`start_date`, `end_date`),
    INDEX `idx_event_status_category` (`status`, `category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
