<?php
define('APP_ABSPATH', dirname(__FILE__).'/app/');
require_once(APP_ABSPATH.'config/app.php');
require_once(APP_ABSPATH.'route.php');

//run the app
$app->run();

?>
