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

/*====================== Error codes =====================*/
$app->get('/errors', function() use ($app) {
	global $messages;
    echoRespnse(0, 'Error Codes',$messages);
});

$app->get('/errors/:id', function($error_id) {
    global $messages;
	if(array_key_exists($error_id, $messages)){
		echoRespnse(0, 'Error Code: '.$error_id,$messages[$error_id]);
	}else{
		echoRespnse(1100,'Invalid code Error');
	}
});

// User id from db - Global Variable
$user_id = NULL;
$bc= new baseController();
require_once(APP_ABSPATH.'../../app/route.php');
?>
