<?php

namespace Altum\Plugin;

use Altum\Plugin;

class Aix {
    public static $plugin_id = 'aix';

    public static function install() {

        /* Run the installation process of the plugin */
        $queries = [
            "INSERT IGNORE INTO `settings` (`key`, `value`) VALUES ('aix', '');",
            "alter table users add aix_words_current_month bigint unsigned default 0 after source;",
            "alter table users add aix_images_current_month bigint unsigned default 0 after source;",
            "CREATE TABLE `documents` (
              `document_id` bigint unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int DEFAULT NULL,
              `project_id` int DEFAULT NULL,
              `name` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `type` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `input` text COLLATE utf8mb4_unicode_ci,
              `content` text COLLATE utf8mb4_unicode_ci,
              `words` int unsigned DEFAULT NULL,
              `settings` text COLLATE utf8mb4_unicode_ci,
              `datetime` datetime DEFAULT NULL,
              `last_datetime` datetime DEFAULT NULL,
              PRIMARY KEY (`document_id`),
              KEY `user_id` (`user_id`),
              KEY `project_id` (`project_id`),
              CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
            "CREATE TABLE `images` (
              `image_id` bigint unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int DEFAULT NULL,
              `project_id` int DEFAULT NULL,
              `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `input` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
              `image` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `size` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
              `datetime` datetime DEFAULT NULL,
              `last_datetime` datetime DEFAULT NULL,
              PRIMARY KEY (`image_id`),
              KEY `user_id` (`user_id`),
              KEY `project_id` (`project_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
        ];

        foreach($queries as $query) {
            database()->query($query);
        }

        return Plugin::save_status(self::$plugin_id, 'active');

    }

    public static function uninstall() {

        /* Run the installation process of the plugin */
        $queries = [
            "DELETE FROM `settings` WHERE `key` = 'aix';",
            "DELETE FROM `settings` WHERE `key` = 'ai_writer';",
            "alter table `users` drop ai_writer_words_current_month;",
            "alter table `users` drop aix_words_current_month;",
            "alter table `users` drop aix_images_current_month;",
            "drop table `documents`",
            "drop table `images`",
        ];

        foreach($queries as $query) {
            try {
                database()->query($query);
            } catch (\Exception $exception) {
                // :)
            }
        }

        return Plugin::save_status(self::$plugin_id, 'uninstalled');

    }

    public static function activate() {
        return Plugin::save_status(self::$plugin_id, 'active');
    }

    public static function disable() {
        return Plugin::save_status(self::$plugin_id, 'installed');
    }

}
