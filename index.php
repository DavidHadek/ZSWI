<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("autoloader.inc.php");

require_once("vendor/autoload.php");

require_once("settings.inc.php");

$app = new \zswi\ApplicationStart();
$app->appStart();