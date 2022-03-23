<?php

namespace App\Controller;

use App\Database\SqlHelper;
use Core\Service;
use PDO;

class Home extends Controller
{
    public function index()
    {
        $db = new SqlHelper();
        $mainPageQuery = "SELECT * FROM `news` LEFT JOIN `users` ON `news`.`user_id` = `users`.`id` WHERE `news`.`status` = 'enable' AND `news`.`main_page` = TRUE ORDER BY `news`.`id` DESC LIMIT 6;";
        $mainPageCount = $db->select($mainPageQuery)->rowCount();
        $mainPage = $db->select($mainPageQuery)->fetchAll(PDO::FETCH_NAMED);
        $perPage = 5;
        $allNewsCount = (int) $db->select("SELECT COUNT(*) FROM `news` WHERE `status` = 'enable';")->fetch(PDO::FETCH_NUM)[0];
        $currentPage = intval($_GET['page'] ?? 1);
        $pages = ceil($allNewsCount/$perPage);
        $currentPage = min($currentPage, $pages);
        $currentPage = max($currentPage, 1);
        $offset = $perPage * ($currentPage - 1);
        $allNews = $db->select("SELECT * FROM `news` LEFT JOIN `users` ON `news`.`user_id` = `users`.`id` LEFT JOIN `groups` ON `news`.`group_id` = `groups`.`id` WHERE `news`.`status` = 'enable' ORDER BY `news`.`id` ASC LIMIT $perPage OFFSET $offset;")->fetchAll(PDO::FETCH_NAMED);
        $db->close();
        $this->view("home.index", compact("mainPageCount","mainPage", "allNews", "pages"));
    }
    public function show($id, $title)
    {
        $id = intval($id);
        $db = new SqlHelper();
        $mainNews = $db->select("SELECT * FROM `news` LEFT JOIN `users` ON `news`.`user_id` = `users`.`id` LEFT JOIN `groups` ON `news`.`group_id` = `groups`.`id` WHERE `news`.`status` = 'enable' AND `news`.`id`=?;",[$id])->fetch(PDO::FETCH_NAMED);
        if (!isRefreshPage()) {
            $visit = intval($mainNews['visit']);
            $visit++;
            $db->update("news", intval($mainNews['id'][0]), ['visit'], ['visit' => $visit]);
        }
        $comments = $db->select("SELECT * FROM `comments` LEFT JOIN `users` ON `comments`.`user_id` = `users`.`id` WHERE `comments`.`status` = 'approved' AND `comments`.`news_id`= ?;", [$id])->fetchAll(PDO::FETCH_NAMED);
        $db->close();
        $this->view("home.show", compact("title","mainNews", "comments"));
    }
    public function commentStore($request, $id)
    {
        $request = array_merge($request, ["news_id" => intval($id)]);
        $request['comment'] = Service::inputFilter($request['comment']);
        $request['user_id'] = intval($request['user_id']);
        $accept = $request['accept'];
        if ($accept == "true") {
            if (empty($request['comment'])) {
                echo "متن نظر نمی تواند خالی باشد";
            } elseif (mystrlen($request['comment']) < 10) {
                echo "متن نظر کوچکتر از 10 کارکتر است";
            } else {
                unset($request['accept']);
                $db = new SqlHelper();
                $db->insert("comments", array_keys($request), $request);
                $db->close();
            }
        } else {
            echo "شما با قوانین سایت مخالفت کردید";
        }
    }
    public function group($id, $title)
    {
        $id = intval($id);
        $title = urldecode($title);
        $perPage = 5;
        $db = new SqlHelper();
        $allNewsCount = $db->select("SELECT COUNT(*) FROM `news` WHERE `status` = 'enable' AND `group_id`= ?;",[$id])->fetch(PDO::FETCH_NUM)[0];
        $currentPage = intval($_GET['page'] ?? 1);
        $pages = ceil($allNewsCount/$perPage);
        $currentPage = min($currentPage, $pages);
        $currentPage = max($currentPage, 1);
        $offset = $perPage * ($currentPage - 1);
        $allNews = $db->select("SELECT * FROM `news` LEFT JOIN `users` ON `news`.`user_id` = `users`.`id` LEFT JOIN `groups` ON `news`.`group_id` = `groups`.`id` WHERE `news`.`status` = 'enable' AND `news`.`group_id`=? ORDER BY `news`.`id` DESC LIMIT $perPage OFFSET $offset;",[$id])->fetchAll(PDO::FETCH_NAMED);
        $db->close();
        $this->view("home.group", compact("title", "allNews", "pages"));
    }
    public function news()
    {
        $perPage = 5;
        $db = new SqlHelper();
        $countNews = (int) $db->select("SELECT COUNT(*) FROM `news` WHERE `status` = 'enable';")->fetch(PDO::FETCH_NUM)[0];
        $currentPage = intval($_GET['page'] ?? 1);
        $pages = ceil($countNews/$perPage);
        $currentPage = min($currentPage, $pages);
        $currentPage = max($currentPage, 1);
        $offset = $perPage * ($currentPage - 1);
        $allNews = $db->select("SELECT * FROM `news` LEFT JOIN `users` ON `news`.`user_id` = `users`.`id` LEFT JOIN `groups` ON `news`.`group_id` = `groups`.`id` WHERE `news`.`status` = 'enable' ORDER BY `news`.`created_at` DESC LIMIT $perPage OFFSET $offset;")->fetchAll(PDO::FETCH_NAMED);
        $db->close();
        $this->view("home.news",compact("allNews", "pages"));
    }
    public function search()
    {
        $news = [];
        $q = $_GET['q'] ?? "";
        $title = "نتیجه جست و جو: "."<em>$q</em>";
        $db = new SqlHelper();
        $query = "WHERE `news`.`summary` LIKE '%".$q."%'";
        $allNews = $db->select("SELECT * FROM `news` LEFT JOIN `users` ON `news`.`user_id` = `users`.`id` LEFT JOIN `groups` ON `news`.`group_id` = `groups`.`id` $query ORDER BY `news`.`created_at` DESC;")->fetchAll(PDO::FETCH_NAMED);
        foreach ($allNews as  $al) {
            if ($al['status'] == "enable") {
                $news[] = $al;
            }
        }
       $this->view("home.search", compact("news", "title"));
    }
}
