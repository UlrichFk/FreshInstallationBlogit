<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    
    
    public function executeQueries()
    {
        try {
            
            $this->insertTranslations();
            $this->insertSettings();
            $this->addPushNotificationColumn();
            $this->createShortVideoAnalyticsTable();
            $this->createShortVideoCommentsTable();
            $this->alterReportCommentsTable();
            $this->addShortVideoCommentIdColumn();
            $this->createAppHomePagesTable();
            
            return response()->json(['message' => 'All queries executed successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function insertTranslations()
    {
        // Insert translations only if they do not exist
        DB::statement("
            INSERT INTO `translations` (`id`, `language_id`, `group`, `keyword`, `key`, `value`, `created_at`, `updated_at`, `deleted_at`) 
                VALUES 
                (NULL, '1', 'api', 'message_comment_deleted_successfully', 'message_comment_deleted_successfully', 'Comment Deleted Successfully', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_app_update_settings', 'admin_app_update_settings', 'Force App Update', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_is_android_app_force_update_placeholder', 'admin_is_android_app_force_update_placeholder', 'Is Android App Force Update Placeholder', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_is_ios_app_force_update_placeholder', 'admin_is_ios_app_force_update_placeholder', 'Is iOS App Force Update Placeholder', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_push_notification_image', 'admin_push_notification_image', 'Image', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_push_notification_image_resolution', 'admin_push_notification_image_resolution', 'Resolution 512x512', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_short_video_views', 'admin_short_video_views', 'Short Video Views', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_total_guest_short_video_views', 'admin_total_guest_short_video_views', 'Total Guest Short Video Views', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_total_short_video_views', 'admin_total_short_video_views', 'Total Short Video Views', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_short_video_share', 'admin_short_video_share', 'Short Video Share', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_enable_stories_placeholder', 'admin_enable_stories_placeholder', 'Enable Stories', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_select_language_appear_or_not_placeholder', 'admin_select_language_appear_or_not_placeholder', 'The selected language page should appear or not', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_enable_skip_placeholder', 'admin_enable_skip_placeholder', 'Skip option in app', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_short_video_like', 'admin_short_video_like', 'Short Video Likes', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_short_video_comment', 'admin_short_video_comment', 'Short Video Comment', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_app_home_page_management', 'admin_app_home_page_management', 'App Home Page', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_app_home_page', 'admin_app_home_page', 'App Home Page', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_create_app_home_page', 'admin_create_app_home_page', 'Create App Home Page', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_type_data', 'admin_type_data', 'Type Data', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_select_type', 'admin_select_type', 'Select Type', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_order', 'admin_order', 'Order', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_add_app_home_page', 'admin_add_app_home_page', 'Add App Home Page', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_ad_views', 'admin_ad_views', 'Ads Views', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_ad_overall_count', 'admin_ad_overall_count', 'Ads Overall Count', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_ads_click', 'admin_ads_click', 'Ads Click', NOW(), NULL, NULL),
                (NULL, '1', 'api', 'dont_have_account', 'dont_have_account', 'Don’t have an account?', NOW(), NULL, NULL),
                (NULL, '1', 'admin', 'admin_clicked_at', 'admin_clicked_at', 'Clicked At', NOW(), NULL, NULL);
            ");
    }

    public function insertSettings()
    {
        DB::statement("
            INSERT INTO settings (`key`, `value`)
            SELECT 'is_android_app_force_update', '0'
            WHERE NOT EXISTS (
                SELECT 1 FROM settings WHERE `key` = 'is_android_app_force_update'
            );
            
            INSERT INTO settings (`key`, `value`)
            SELECT 'is_ios_app_force_update', '0'
            WHERE NOT EXISTS (
                SELECT 1 FROM settings WHERE `key` = 'is_ios_app_force_update'
            );

            INSERT INTO settings (`key`, `value`)
            SELECT 'enable_stories', '0'
            WHERE NOT EXISTS (
                SELECT 1 FROM settings WHERE `key` = 'enable_stories'
            );
            
            INSERT INTO settings (`key`, `value`)
            SELECT 'enable_select_language_appear', '0'
            WHERE NOT EXISTS (
                SELECT 1 FROM settings WHERE `key` = 'enable_select_language_appear'
            );
            
            
            INSERT INTO settings (`key`, `value`)
            SELECT 'enable_skip', '0'
            WHERE NOT EXISTS (
                SELECT 1 FROM settings WHERE `key` = 'enable_skip'
            );
        ");
    }


    public function addPushNotificationColumn()
    {
        // Check if the 'image' column already exists in the 'push_notifications' table
        $columnExists = DB::table('INFORMATION_SCHEMA.COLUMNS')
            ->where('TABLE_NAME', 'push_notifications')
            ->where('COLUMN_NAME', 'image')
            ->exists();
    
        // If the column does not exist, add it
        if (!$columnExists) {
            DB::statement("
                ALTER TABLE `push_notifications` 
                ADD COLUMN `image` VARCHAR(255) NULL AFTER `description`;
            ");
        }
    }

    public function createShortVideoAnalyticsTable()
    {
        // Create table only if it does not exist
        DB::statement("
            CREATE TABLE IF NOT EXISTS `short_video_analytics` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `type` ENUM('view', 'like', 'share') DEFAULT 'view',
                `user_id` INT DEFAULT 0,
                `player_id` VARCHAR(255) NULL,
                `fcm_token` TEXT NULL,
                `short_video_id` BIGINT UNSIGNED DEFAULT 0,
                `created_at` TIMESTAMP NULL DEFAULT NULL,
                `updated_at` TIMESTAMP NULL DEFAULT NULL,
                INDEX (`type`),
                INDEX (`user_id`),
                INDEX (`short_video_id`),
                INDEX (`player_id`),
                INDEX (`fcm_token`(191)),
                INDEX (`created_at`),
                INDEX (`updated_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    }

    public function createShortVideoCommentsTable()
    {
        // Create table only if it does not exist
        DB::statement("
            CREATE TABLE IF NOT EXISTS `short_video_comments` (
              `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
              `user_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
              `short_video_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
              `comment` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `status` TINYINT(4) NOT NULL DEFAULT 1,
              `approval_status` TINYINT(4) NOT NULL DEFAULT 0,
              `created_at` TIMESTAMP NULL DEFAULT NULL,
              `updated_at` TIMESTAMP NULL DEFAULT NULL,
              `deleted_at` TIMESTAMP NULL DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `user_id` (`user_id`),
              KEY `short_video_id` (`short_video_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    }

    public function alterReportCommentsTable()
    {
        // Check if the 'short_video_comment_id' column already exists in the 'report_comments' table
        $columnExists = DB::table('INFORMATION_SCHEMA.COLUMNS')
            ->where('TABLE_NAME', 'report_comments')
            ->where('COLUMN_NAME', 'short_video_comment_id')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->exists();
    
        // If the column does not exist, add it
        if (!$columnExists) {
            DB::statement("ALTER TABLE `report_comments`
                ADD COLUMN `short_video_comment_id` BIGINT(20) UNSIGNED NULL AFTER `comment_id`;
            ");
        }
    }

    public function addShortVideoCommentIdColumn()
    {
        // Check if the 'short_video_comment_id' column already exists in the 'report_comments' table
        $columnExists = DB::table('INFORMATION_SCHEMA.COLUMNS')
            ->where('TABLE_NAME', 'report_comments')
            ->where('COLUMN_NAME', 'short_video_comment_id')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->exists();
    
        // If the column does not exist, add it
        if (!$columnExists) {
            DB::statement("
                ALTER TABLE `report_comments` 
                ADD COLUMN `short_video_comment_id` BIGINT(20) UNSIGNED NULL AFTER `comment_id`;
            ");
        }
    }

    public function createAppHomePagesTable()
    {
        // Create table only if it does not exist
        DB::statement("
            CREATE TABLE IF NOT EXISTS `app_home_pages` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) DEFAULT NULL,
                `type` VARCHAR(255) DEFAULT NULL,
                `category_id` VARCHAR(255) DEFAULT '0',
                `sub_category_id` VARCHAR(255) DEFAULT '0',
                `visibility_id` INT DEFAULT 0,
                `order` INT DEFAULT 1,
                `status` TINYINT DEFAULT 1,
                `created_at` TIMESTAMP NULL DEFAULT NULL,
                `updated_at` TIMESTAMP NULL DEFAULT NULL,
                INDEX (`title`),
                INDEX (`type`),
                INDEX (`order`),
                INDEX (`category_id`),
                INDEX (`sub_category_id`),
                INDEX (`visibility_id`),
                INDEX (`created_at`),
                INDEX (`updated_at`),
                INDEX (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    }
    
}