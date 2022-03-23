<?php


namespace App\Database;


use PDO;

class AdminQuery
{
    public static function unseenCommentCount()
    {
        $db = new SqlHelper();
        $count = $db->select("SELECT COUNT(*) FROM `comments` WHERE `status` = 'unseen';")->fetch(PDO::FETCH_NUM)[0];
        $db->close();
        return $count;
    }
}