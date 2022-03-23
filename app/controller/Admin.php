<?php

namespace App\Controller;

use App\Database\AdminQuery;
use App\Database\SqlHelper;
use Core\Service;
use PDO;

class Admin extends Controller
{
    public function __construct()
    {
        $auth = new Auth();
        $auth->checkAdmin();
    }
    public function index()
    {
        $db = new SqlHelper();
        $groupCount = $db->select("SELECT COUNT(*) AS `group_count` FROM `groups`;")->fetch();
        $newsCount = $db->select("SELECT COUNT(*) AS `news_count` FROM `news`;")->fetch();
        $newsShowCount = $db->select("SELECT COUNT(*) AS `news_show_count` FROM `news` WHERE `status` = 'enable';")->fetch();
        $userCount = $db->select("SELECT COUNT(*) AS `user_count` FROM `users`;")->fetch();
        $count = array_merge($groupCount, $newsCount, $newsShowCount ,$userCount);
        $db->close();
        $this->view("admin.index", compact("count"));
    }
    public function listUser()
    {
        $db = new SqlHelper();
        $allUsers = $db->select("SELECT * FROM `users` ORDER BY `id` ASC;")->fetchAll();
        $db->close();
        $this->view("admin.list_user", compact("allUsers"));
    }
    public function switchUser($id)
    {
        $db = new SqlHelper();
        $user = $db->select("SELECT * FROM `users` WHERE `id`= ?;", [$id])->fetch();
        $message = $user['permission'] == "admin" ? "user" : "admin";
        $db->update("users", $id, ["permission"], ["permission" => $message]);
        $db->close();
        $this->redirectUrlBack();
    }
    public function commentManger()
    {
        $db = new SqlHelper();
        $allCommentCount = $db->select("SELECT * FROM `comments` ORDER BY `id` DESC;")->rowCount();
        $allComments = $db->select("SELECT * FROM `comments` LEFT JOIN `users` ON `comments`.`user_id` = `users`.`id` LEFT JOIN `news` ON `comments`.`news_id` = `news`.`id`  ORDER BY `comments`.`id` DESC;")->fetchAll(PDO::FETCH_NAMED);
        $db->close();
        $this->view("admin.comment_manger", compact("allCommentCount","allComments"));
    }
    public function switchStatusComment($id)
    {
        if (!isOpenPageAjax()) {
            $this->redirectUrl("admin/comment-manger");
        }
        $id = intval($id);
        $db = new SqlHelper();
        $comment = $db->select("SELECT * FROM `comments` WHERE `id`= ?;", [$id])->fetch();
        switch ($comment['status']) {
            case "unseen":
                $db->update("comments", $id, ["status"], ["status" => "seen"]);
                $countUnseen = AdminQuery::unseenCommentCount();
                echo "btn btn-resize btn-primary@$countUnseen";
                break;
            case "seen":
                $db->update("comments", $id, ["status"], ["status" => "approved"]);
                $countUnseen = AdminQuery::unseenCommentCount();
                echo "btn btn-resize btn-success@$countUnseen";
                break;
            case "approved":
                $db->update("comments", $id, ["status"], ["status" => "unseen"]);
                $countUnseen = AdminQuery::unseenCommentCount();
                echo "btn btn-resize btn-warning@$countUnseen";
                break;
        }
        $db->close();
    }
    public function showComment($id)
    {
        $id = intval($id);
        $db = new SqlHelper();
        $comment = $db->select("SELECT * FROM `comments` LEFT JOIN `users` ON `comments`.`user_id` = `users`.`id` LEFT JOIN `news` ON `comments`.`news_id` = `news`.`id`  WHERE `comments`.`id`= ?;", [$id])->fetch(PDO::FETCH_NAMED);
        $db->close();
        if (!isOpenPageAjax()) $this->error404();
        $this->view("admin.comment_show", compact("comment"));
    }
    public function editComment($id)
    {
        $id = intval($id);
        $db = new SqlHelper();
        $comment = $db->select("SELECT * FROM `comments` WHERE `status` != 'unseen' AND `id`= ? ;", [$id])->fetch();
        $db->close();
        if (!isOpenPageAjax()) $this->error404();
        $this->view("admin.comment_edit", compact("comment"));
    }
    public function updateComment($request, $id)
    {
        $request['comment'] = Service::inputFilter($request['comment']);
        $db = new SqlHelper();
        if (empty($request['comment'])) {
            $_SESSION['COMMENT_ERROR'] = "متن نظر خالی است!!";
            $db->close();
            $this->redirectUrl("admin/comment-manger");
        } elseif (mystrlen($request['comment']) < 10) {
            $_SESSION['COMMENT_ERROR'] = "متن نظر کمتر از 10 کارکتر است!!";
            $db->close();
            $this->redirectUrl("admin/comment-manger");
        } else {
            $db->update("comments", $id, array_keys($request), $request);
            $db->close();
            unset($_SESSION['COMMENT_ERROR']);
            $this->redirectUrl("admin/comment-manger");
        }
    }
    public function destroyComment($id)
    {
        $db = new SqlHelper();
        $db->delete("comments", intval($id));
        $db->close();
        $this->redirectUrlBack();
    }
    public function seenAllComment()
    {
        $db = new SqlHelper();
        $comments = $db->select("SELECT * FROM `comments` ORDER BY `id` DESC;")->fetchAll();
        foreach ($comments as $comment) {
            if ($comment['status'] == "unseen") {
                $db->update("comments", $comment['id'], ["status"], ["status" => "seen"]);
            }
        }
        $db->close();
        $this->redirectUrl("admin/comment-manger");
    }
    public function search($request)
    {
        $rows = [];
        $q = Service::inputFilter($request['q']);
        $db = new SqlHelper();
        $groups = $db->select("SELECT * FROM `groups` ORDER BY `id` DESC ;")->fetchAll();
        $allUsers = $db->select("SELECT * FROM `users` ORDER BY `id` ASC;")->fetchAll();
        $allComments = $db->select("SELECT * FROM `comments` LEFT JOIN `users` ON `comments`.`user_id` = `users`.`id` LEFT JOIN `news` ON `comments`.`news_id` = `news`.`id`  ORDER BY `comments`.`id` DESC;")->fetchAll(PDO::FETCH_NAMED);
        $news = $db->select("SELECT * FROM `news` LEFT JOIN `groups` ON `news`.`group_id` = `groups`.`id` LEFT JOIN `users` ON `news`.`user_id` = `users`.`id` ORDER BY `news`.`id` DESC;")->fetchAll(PDO::FETCH_NAMED);
        $db->close();
        $url = $request['url'];
        if ($url == "news") {
            foreach ($news as $n) {
                if (contains($n['title'][0], $q, true) or contains($n['summary'], $q, true)) {
                    array_push($rows, $n);
                }
            }
            $newsCount = sizeof($rows);
            $news = $rows;
            $this->view("admin_news.news", compact("newsCount", "news"));
        } elseif ($url == "groups") {
            foreach ($groups as $group) {
                if (contains($group['title'], $q, true)) {
                    array_push($rows, $group);
                }
            }
            $groups = $rows;
            $this->view("admin_groups.groups", compact("groups"));
        } elseif ($url == "list-user") {
            foreach ($allUsers as $allUser) {
                if (contains($allUser['username'], $q, true) or contains($allUser['email'], $q, true)) {
                    array_push($rows, $allUser);
                }
            }
            $allUsers = $rows;
            $this->view("admin.list_user", compact("allUsers"));
        } elseif ($url == "comment-manger") {
            foreach ($allComments as $allComment) {
                if (contains($allComment['comment'], $q, true)) {
                    array_push($rows, $allComment);
                }
            }
            $allCommentCount = sizeof($rows);
            $allComments = $rows;
            $this->view("admin.comment_manger", compact("allCommentCount","allComments"));
        }
    }
}