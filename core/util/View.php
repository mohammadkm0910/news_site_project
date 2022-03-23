<?php

namespace Core\Util;

use Core\Service;

trait View
{
    protected function view($dir, $vars = null)
    {
        $dir = str_replace(".", "/", $dir);
        if ($vars) extract($vars);
        $path = glob(BASE_PATH.fix_path("/app/view/$dir").".*")[0];
        if (file_exists($path))
            require_once($path);
        else
            echo "this view [$dir] not exist";
    }
    protected function asset($src)
    {
        $src = str_replace("asset", "", $src);
        $src = trim($src, "/");
        echo BASE_ASSET."/$src";
    }
    protected function url($address)
    {
        $address = trim($address, "/");
        echo BASE_URL."/$address";
    }
    protected function partial($dir, $vars = null)
    {
        $dir = str_replace(".", "/", $dir);
        if ($vars) extract($vars);
        $path = glob(BASE_PATH.fix_path("/app/view/partial/$dir").".*")[0];
        if (file_exists($path))
            require_once($path);
        else
            echo "this partial [$dir] not exist";
    }
    protected function error404()
    {
        http_response_code(404);
        require_once fix_path(BASE_PATH."/app/view/error/error404.php");
        exit();
    }
}