<?php


namespace App\Database;

use Core\Service;

class CreateSql
{
    private $tables = array(
        "CREATE TABLE IF NOT EXISTS `groups` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",
        "CREATE TABLE IF NOT EXISTS `news` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
            `summary` text COLLATE utf8_persian_ci NOT NULL,
            `body` text COLLATE utf8_persian_ci NOT NULL,
            `visit` int(11) NOT NULL DEFAULT '0',
            `user_id` int(11)  NOT NULL,
            `group_id` int(11)  NOT NULL,
            `shortcut` varchar(200) COLLATE utf8_persian_ci DEFAULT NULL,
            `image` varchar(200) COLLATE utf8_persian_ci DEFAULT NULL,
            `status` enum('disable','enable') COLLATE utf8_persian_ci NOT NULL DEFAULT 'disable',
            `main_page` boolean NOT NULL DEFAULT false,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime DEFAULT NULL,
             PRIMARY KEY (`id`),
             FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
             FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",
        "CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(100) COLLATE utf8_persian_ci NOT NULL,
            `email` varchar(150) COLLATE utf8_persian_ci NOT NULL,
            `password` varchar(100) COLLATE utf8_persian_ci NOT NULL,
            `permission` enum('user','admin') COLLATE utf8_persian_ci NOT NULL DEFAULT 'user',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime DEFAULT NULL,
             PRIMARY KEY (`id`),
             UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",
        "CREATE TABLE IF NOT EXISTS `comments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `comment` text COLLATE utf8_persian_ci NOT NULL,
            `news_id` int(11) NOT NULL,
            `status` enum('unseen','seen','approved') COLLATE utf8_persian_ci NOT NULL DEFAULT 'unseen',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime DEFAULT NULL,
             PRIMARY KEY (`id`),
             FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
             FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;"
    );
    public function run($isPermission = false)
    {
        $dbInfo = Service::databaseInfo();
        $dbName = $dbInfo['DB_NAME'];
        if (!$isPermission) exit;
        $connection = new \mysqli($dbInfo['DB_HOST'], $dbInfo['DB_USERNAME'], $dbInfo['DB_PASSWORD']);
        $query = "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8 COLLATE utf8_general_ci;";
        $connection->query($query);
        $connection->close();
        $db = new SqlHelper();
        foreach ($this->tables as $table) {
            $db->createTable($table);
        }
        $db->close();
    }
}