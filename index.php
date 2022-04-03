<?php

use Core\Router\Routing;

include("core/startup.php");

//$cq = new \App\Database\CreateSql();
//$cq->run(true);

//$backup = new \App\Database\Backup();
//$backup->restore();
//$backup->run();

//$backup->deleteImagesUnAvailableDB();

$routing = new Routing();
$routing->run();