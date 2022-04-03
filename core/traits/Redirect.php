<?php

namespace Core\Traits;

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
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: ".$_SERVER['HTTP_REFERER']);
        } else {
            echo "route not found";
        }
        exit();
    }
}