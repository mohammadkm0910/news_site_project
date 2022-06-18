<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mainDir = dirname(__DIR__);
$protocol = (stripos($_SERVER['SERVER_PROTOCOL'], "https") === 0 ? "https" : "http")."://";
$host = $_SERVER['HTTP_HOST'];
$root = substr($mainDir, strrpos($mainDir, DIRECTORY_SEPARATOR) + 1);
$temporary = explode("?", $_SERVER['REQUEST_URI'])[0];
$temporary = $temporary === "/" ? "" : substr($temporary, 1);
$address = explode("/", $temporary);
$isDomain = $address[0] !== $root;

const DS = DIRECTORY_SEPARATOR;
define("BASE_PATH", $mainDir);
define("ROOT", $root);
define("PROTOCOL", $protocol);
define("BASE_URL", !$isDomain ? $protocol.$host."/$root" : $protocol.$host);
define("BASE_ASSET", !$isDomain ? $protocol.$host."/$root/asset" : $protocol.$host."/asset");
define("CURRENT_ROUTE", $temporary);

global $routes;
$routes = ['get' => [], 'post' => []];

unset($mainDir);
unset($temporary);
unset($root);
unset($host);
unset($protocol);