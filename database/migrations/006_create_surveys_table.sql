-- Migration: 006_create_surveys_table.sql
-- Description: Create surveys, survey_questions, survey_responses, and survey_answers tables

CREATE TABLE IF NOT EXISTS `surveys` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `description` TEXT NULL DEFAULT NULL,
    `category` VARCHAR(100) NOT NULL DEFAULT 'satisfaction',
    `target_audience` ENUM('all', 'members_only', 'public') NOT NULL DEFAULT 'all',
    `status` ENUM('draft', 'active', 'closed') NOT NULL DEFAULT 'active',
    `start_date` DATE NOT NULL,
    `end_date` DATE NULL DEFAULT NULL,
    `is_anonymous` TINYINT(1) NOT NULL DEFAULT 1,
    `allow_multiple_responses` TINYINT(1) NOT NULL DEFAULT 0,
    `thank_you_message` TEXT NULL DEFAULT NULL,
    `created_by` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_surveys_status_dates` (`status`, `start_date`, `end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `survey_questions` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `survey_id` BIGINT(20) UNSIGNED NOT NULL,
    `question_text` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NULL DEFAULT NULL,
    `question_type` ENUM('rating_1_5', 'single_choice', 'multiple_choice', 'text') NOT NULL DEFAULT 'rating_1_5',
    `options_json` JSON NULL DEFAULT NULL,
    `is_required` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT(11) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_survey_q_survey` (`survey_id`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `survey_responses` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `survey_id` BIGINT(20) UNSIGNED NOT NULL,
    `member_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `session_token` VARCHAR(64) NULL DEFAULT NULL,
    `ip_address` VARCHAR(45) NULL DEFAULT NULL,
    `user_agent` VARCHAR(255) NULL DEFAULT NULL,
    `submitted_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_survey_res_survey` (`survey_id`),
    INDEX `idx_survey_res_member` (`member_id`, `survey_id`),
    INDEX `idx_survey_res_token` (`session_token`, `survey_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `survey_answers` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `response_id` BIGINT(20) UNSIGNED NOT NULL,
    `question_id` BIGINT(20) UNSIGNED NOT NULL,
    `rating_value` INT(11) NULL DEFAULT NULL,
    `answer_text` TEXT NULL DEFAULT NULL,
    `selected_options_json` JSON NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_survey_ans_response` (`response_id`),
    INDEX `idx_survey_ans_question` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
