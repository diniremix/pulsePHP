<?php 
/*=========== App Configuration ==========*/
define('APP_ABSPATH', dirname(__FILE__).'/');
require_once(APP_ABSPATH.'Config.php');
require_once(APP_ABSPATH.'errorCodes.php');
require_once(APP_ABSPATH.'../includes/utils.php');
require_once(APP_ABSPATH.'../includes/database.php');
require_once(APP_ABSPATH.'../includes/auth.php');
require_once(APP_ABSPATH.'../controllers/baseController.php');
require_once('../app/vendor/Slim/Slim.php');

/*====================== App Route Configuration =====================*/
// initialize Slim
\Slim\Slim::registerAutoloader();

// Set the current mode
$app = new \Slim\Slim(array(
    'mode' => 'development'
));

// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => false,
        'debug' => true
    ));
});

// User id from db - Global Variable
$user_id = NULL;
$bc= new baseController();
?>
