<?php


namespace App\Database;


class AppQuery
{
    public static function commentNewsCountByNewsId($id) {
        $id = intval($id);
        $db = new SqlHelper();
        $count = $db->select("SELECT COUNT(*) AS `count` FROM `comments` WHERE `news_id`=?;", [$id])->fetch();
        $db->close();
        return $count['count'];
    }
    public static function mostCommentedNewsSidebar(): array
    {
        $temp = array();
        $db = new SqlHelper();
        $news = $db->select("SELECT * FROM `news` WHERE `status` = 'enable' ORDER BY `id` DESC;")->fetchAll();
        foreach ($news as $mn) {
            array_push($temp, ["comment_count" =>self::commentNewsCountByNewsId($mn['id']), $mn]);
        }
        $db->close();
        rsort($temp);
        return array_slice($temp, 0, 5);
    }
    public static function mostViewNewsSidebar(): array
    {
        $db = new SqlHelper();
        $news = $db->select("SELECT * FROM `news` WHERE `status` = 'enable' ORDER BY `visit` DESC LIMIT 5;")->fetchAll();
        $db->close();
        return $news;
    }
}