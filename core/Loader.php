<?php

namespace Core;

class Loader
{
    function autoload() {
        spl_autoload_register(function ($namespace) {
            $className = substr($namespace, strrpos($namespace, '\\') + 1);
            $classPath = strtolower(substr($namespace, 0, strrpos($namespace, '\\')));
            include_once fix_path(BASE_PATH."/$classPath/$className.php");
        });
    }
}