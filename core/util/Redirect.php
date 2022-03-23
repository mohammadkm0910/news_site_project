<?php


namespace Core\Util;

use Core\Service;

trait Redirect
{
    protected function redirectUrl($url)
    {
        $url = trim($url, "/");
        $requestUrl = BASE_URL."/$url";
        header("Location: $requestUrl");
        exit();
    }
    protected function redirectUrlBack()
    {
        $http_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
        if ($http_referer != null) {
            header("Location: ".$_SERVER['HTTP_REFERER']);
        } else {
            echo "route not found";
        }
        exit();
    }
}