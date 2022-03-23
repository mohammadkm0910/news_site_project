<?php

namespace Core\Router;

class Route
{
    public static function get($url, $executor, $name = null)
    {
        $executor = explode('@', $executor);
        $class = $executor[0];
        $method = $executor[1];
        $GLOBALS['routes']['get'][] = ['url' => trim($url, '/'), 'class' => $class, 'method' => $method, 'name' => $name];
    }
    public static function post($url, $executor, $name = null)
    {
        $executor = explode('@', $executor);
        $class = $executor[0];
        $method = $executor[1];
        $GLOBALS['routes']['post'][] = ['url' => trim($url, '/'), 'class' => $class, 'method' => $method, 'name' => $name];
    }
}