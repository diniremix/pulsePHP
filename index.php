<?php
define('APP_ABSPATH', dirname(__FILE__));
define('APP_PATH', APP_ABSPATH.DIRECTORY_SEPARATOR.'app');
require_once(APP_PATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'app.php');

$app->run();
?>
