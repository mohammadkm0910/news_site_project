<?php


namespace App\Controller;

use App\Database\SqlHelper;
use Core\Service;
use PDO;

class AdminNews extends Controller
{
    public function __construct()
    {
        $auth = new Auth();
        $auth->checkAdmin();
    }
    public function index()
    {
        $db = new SqlHelper();
        $newsCount = $db->select("SELECT * FROM `news` ORDER BY `id` DESC ;")->rowCount();
        $query = $db->select("SELECT * FROM `news` LEFT JOIN `groups` ON `news`.`group_id` = `groups`.`id` LEFT JOIN `users` ON `news`.`user_id` = `users`.`id` ORDER BY `news`.`id` DESC;");
        $news = $query->fetchAll(PDO::FETCH_NAMED);
        $db->close();
        $this->view("admin_news.news", compact("newsCount", "news"));
    }
    public function create()
    {
        $db = new SqlHelper();
        $groupCount = $db->select("SELECT * FROM `groups` ORDER BY `id` DESC ;")->rowCount();
        $groups = $db->select("SELECT * FROM `groups` ORDER BY `id` DESC ;")->fetchAll();
        $db->close();
        if ($groupCount == 0) $this->redirectUrl('admin/groups');
        $this->view("admin_news.create", compact("groups"));
    }
    public function store($request)
    {
        $db = new SqlHelper();
        if ($request['group_id']) {
            $request = array_merge($request, array("user_id" => Service::loginUser()['id']));
            $request['title'] = Service::inputFilter($request['title']);
            $request['summary'] = Service::inputFilter($request['summary']);
            $request['image'] = $request['image']['name'] ? $this->saveImage($request['image'], "site") : null;
            $request['shortcut'] = $request['shortcut'] ? Service::inputFilter($request['shortcut']) : null;
            $request['main_page'] = isset($request['main_page']);
            if (empty($request['title']) or empty($request['summary']) or empty($request['body'])) {
                $db->close();
                $this->redirectUrlBack();
            } elseif ((mystrlen($request['title']) < 4) or (mystrlen($request['summary']) < 25) or (mystrlen($request['body']) < 100)) {
                $db->close();
                $this->redirectUrlBack();
            } else {
                $db->insert("news", array_keys($request), $request);
                $db->close();
                $this->redirectUrl("admin/news");
            }
        } else {
            $db->close();
            $this->redirectUrlBack();
        }
    }
    public function edit($id) {
        $id = intval($id);
        $db = new SqlHelper();
        $groups = $db->select("SELECT * FROM `groups` ORDER BY `id` DESC ;")->fetchAll();
        $singleNews = $db->select("SELECT * FROM `news` WHERE `id`=? ;",[$id])->fetch();
        $db->close();
        if (empty($singleNews)) $this->redirectUrl("admin/news");
        $this->view("admin_news.edit", compact("groups", "singleNews"));
    }
    public function update($request, $id) {
        $db = new SqlHelper();
        $singleNews = $db->select("SELECT * FROM `news` WHERE `id`=? ;",[$id])->fetch();
        if ($request['group_id']) {
            $request = array_merge($request, array("user_id" => Service::loginUser()['id']));
            $request['title'] = Service::inputFilter($request['title']);
            $request['summary'] = Service::inputFilter($request['summary']);
            if ($request['image']['name']) {
                $this->removeImage($singleNews['image']);
                $request['image'] = $this->saveImage($request['image'], "site");
            } else {
                unset($request['image']);
            }
            $request['shortcut'] = $request['shortcut'] ? Service::inputFilter($request['shortcut']) : null;
            $request['main_page'] = isset($request['main_page']);
            if (empty($request['title']) or empty($request['summary']) or empty($request['body'])) {
                $db->close();
                $this->redirectUrlBack();
            } elseif ((mystrlen($request['title']) < 4) or (mystrlen($request['summary']) < 25) or (mystrlen($request['body']) < 100)) {
                $db->close();
                $this->redirectUrlBack();
            } else {
                $db->update("news",$id, array_keys($request), $request);
                $db->close();
                $this->redirectUrl("admin/news");
            }
        } else {
            $db->close();
            $this->redirectUrlBack();
        }
    }
    public function destroy($id)
    {
        $id = intval($id);
        $db = new SqlHelper();
        $singleNews = $db->select("SELECT * FROM `news` WHERE `id`=? ;",[$id])->fetch();
        if ($singleNews['image']) {
            $this->removeImage($singleNews['image']);
        }
        $db->delete("news", $id);
        $this->redirectUrlBack();
    }
    public function show($id)
    {
        $id = intval($id);
        $db = new SqlHelper();
        $query = $db->select("SELECT * FROM `news` LEFT JOIN `groups` ON `news`.`group_id` = `groups`.`id` LEFT JOIN `users` ON `news`.`user_id` = `users`.`id` WHERE `news`.`id`=? ;",[$id]);
        $singleNews = $query->fetch(PDO::FETCH_NAMED);
        $db->close();
        if (empty($singleNews)) $this->redirectUrl("admin/news");
        $this->view("admin_news.show", compact("singleNews"));
    }
}