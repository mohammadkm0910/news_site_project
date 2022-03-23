<?php


namespace App\Controller;

use App\Database\SqlHelper;
use Core\Service;

require_once(BASE_PATH."/vendor/jdf.php");

class AdminGroups extends Controller
{
    public function __construct()
    {
        $auth = new Auth();
        $auth->checkAdmin();
    }
    public function index()
    {
        $db = new SqlHelper();
        $groups = $db->select("SELECT * FROM `groups` ORDER BY `id` DESC ;")->fetchAll();
        $db->close();
        $this->view("admin_groups.groups", compact("groups"));
    }
    public function create()
    {
        if (!isOpenPageAjax()) $this->redirectUrl("admin/groups");
        $this->view("admin_groups.create");
    }
    public function store($request)
    {
        $title = Service::inputFilter($request['title']);
        $db = new SqlHelper();
        if (empty($title)) {
            $_SESSION['ERROR_GROUP'] = "عنوان گروه خالی است";
            $this->redirectUrlBack();
        } elseif (mystrlen($title) < 4 or mystrlen($title) > 80) {
            $_SESSION['ERROR_GROUP'] = "عنوان گروه بین 4 تا 80 کارکتر است";
            $this->redirectUrlBack();
        } else {
            $request['title'] = $title;
            $db->insert("groups", array_keys($request), $request);
            $db->close();
            unset($_SESSION['ERROR_GROUP']);
            $this->redirectUrl("admin/groups");
        }
    }
    public function edit($id)
    {
        $id = intval($id);
        $db = new SqlHelper();
        $group = $db->select("SELECT * FROM `groups` WHERE `id`= ?;",[$id])->fetch();
        $db->close();
        if (!isOpenPageAjax()) $this->redirectUrl("admin/groups");
        $this->view("admin_groups.edit", compact("id", "group"));
    }
    public function update($request, $id) {
        $db = new SqlHelper();
        $title = Service::inputFilter($request['title']);
        if (empty($title)) {
            $_SESSION['ERROR_GROUP'] = "عنوان گروه خالی است";
            $this->redirectUrlBack();
        } elseif (mystrlen($title) < 4 or mystrlen($title) > 80) {
            $_SESSION['ERROR_GROUP'] = "عنوان گروه بین 4 تا 80 کارکتر است";
            $this->redirectUrlBack();
        } else {
            $request['title'] = $title;
            $db->update("groups",$id, array_keys($request), $request);
            $db->close();
            unset($_SESSION['ERROR_GROUP']);
            $this->redirectUrl("admin/groups");
        }
    }
    public function destroy($id)
    {
        $id = intval($id);
        $db = new SqlHelper();
        $db->delete("groups", $id);
        $db->close();
        $this->redirectUrl("admin/groups");
    }
    public function show($id)
    {
        $id = intval($id);
        $db = new SqlHelper();
        $group = $db->select("SELECT * FROM `groups` WHERE `id`= ?;",[$id])->fetch();
        $db->close();
        if (empty($group)) $this->redirectUrl('admin/groups');
        $this->view("admin_groups.show", compact("group"));
    }
}