<?php

namespace App\Database;

class Backup
{
    public static function run()
    {
        $db = new SqlHelper();
        $groups = $db->select("SELECT * FROM `groups`")->fetchAll();
        $users = $db->select("SELECT * FROM `users`")->fetchAll();
        $news = $db->select("SELECT * FROM `news`")->fetchAll();
        $comments = $db->select("SELECT * FROM `comments`")->fetchAll();
        $dbInfo = [$groups, $users, $news, $comments];
        $dbInfo = base64_encode(serialize($dbInfo));
        $backupDb = fix_path(BASE_PATH."/app/database/backup.db");
        fwrite(fopen($backupDb, 'w'), $dbInfo);
        $db->close();
    }
    public static function restore()
    {
        $db = new SqlHelper();
        $backupDb = fix_path(BASE_PATH."/app/database/backup.db");
        $tables = ["groups", "users", "news", "comments"];
        $dbInfo = unserialize(base64_decode(file_get_contents($backupDb)));
        for ($i = 0; $i < sizeof($tables); $i++) {
            foreach ($dbInfo[$i] as $value) {
                $db->insert($tables[$i], array_keys($dbInfo[$i][0]), $value);
            }
        }
        $db->close();
    }
    public static function deleteImagesUnAvailableDB()
    {
        $db = new SqlHelper();
        $news = $db->select("SELECT * FROM `news`")->fetchAll();
        $news = array_column($news, 'image');
        $imageList = [];
        foreach (glob(fix_path(BASE_PATH. "/asset/images/site/*.*")) as $image) {
            $img = $image;
            $img = substr(str_replace(BASE_PATH, "", $img), 1);
            $img = str_replace("\\", "/", $img);
            $imageList[] = $img;
        }
        $files = array_diff($imageList, $news);
        foreach ($files as $file) {
            unlink(fix_path(BASE_PATH. "/$file"));
        }
        $db->close();
    }
}