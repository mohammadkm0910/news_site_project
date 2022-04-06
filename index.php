<?php

use Core\Router\Routing;

include("core/startup.php");

//\App\Database\CreateSql::run(true);

//\App\Database\Backup::restore();

//\App\Database\Backup::run();

//\App\Database\Backup::deleteImagesUnAvailableDB();

$routing = new Routing();
$routing->run();