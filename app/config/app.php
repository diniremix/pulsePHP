<?php 
/*=========== App Configuration ==========*/
require_once(APP_ABSPATH.'config/Config.php');
require_once(APP_ABSPATH.'config/databases.php');
require_once(APP_ABSPATH.'config/errorCodes.php');
require_once(APP_ABSPATH.'libraries/utils.php');
require_once(APP_ABSPATH.'libraries/database.php');
require_once(APP_ABSPATH.'libraries/auth.php');
require_once(APP_ABSPATH.'libraries/sessions.php');
require_once(APP_ABSPATH.'libraries/pulseAcl.php');
require_once(APP_ABSPATH.'libraries/pulseLog.php');
require_once(APP_ABSPATH.'controllers/baseController.php');
require_once(APP_ABSPATH.'vendor/Slim/Slim.php');

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
        'debug' => false,
        'templates.path' => './'.TEMPLATES_PATH
    ));
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => false,
        'debug' => true,
        'templates.path' => './'.TEMPLATES_PATH
    ));
});

// User id from db - Global Variable
$user_id = NULL;
$bc= new baseController();
?>
