<?php

namespace Core;

use App\Database\SqlHelper;

class Service
{
    public static function getDomain()
    {
        return PROTOCOL.$_SERVER['HTTP_HOST'];
    }
    public static function getCurrentUrl()
    {
        return trim(self::getDomain(), "/")."/".trim(urldecode($_SERVER['REQUEST_URI']), "/");
    }
    public static function getMethodField()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    public static function isInternetExplore()
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false;
    }

    public static function isMicrosoftEdge()
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'Edg') !== false;
    }
    public static function inputFilter($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        return htmlspecialchars($data);
    }
    public static function loginUser() {
        $isSessionUser = (isset($_SESSION['USER']) and trim($_SESSION['USER']) != "");
        $isCookieUser = (isset($_COOKIE['USER']) and trim($_COOKIE['USER']) != "");
        if ($isSessionUser) {
            $id = $_SESSION['USER'];
        } elseif ($isCookieUser) {
            $id = $_COOKIE['USER'];
        } else {
            $id = null;
        }
        $db = new SqlHelper();
        $user = $db->select("SELECT * FROM `users` WHERE `id` = ? ;",[$id])->fetch();
        $db->close();
        return $user;
    }
    public static function databaseInfo()
    {
        return [
            'DB_HOST' => "localhost",
            'DB_NAME' => "toranji",
            'DB_USERNAME' => "root",
            'DB_PASSWORD' => ""
        ];
    }
}