<?php

use Core\Loader;
use Core\Router\Routing;

session_start();
date_default_timezone_set("Iran");

require_once ("core/utils.php");
require_once("core/Loader.php");

$loader = new Loader();
$loader->autoload();

require_once(dirname(__DIR__)."/config/app.php");
require_once(dirname(__DIR__)."/config/routes.php");
require_once(dirname(__DIR__)."/vendor/jdf.php");
require_once("core/Service.php");


$routing = new Routing();
$routing->run();

