<?php
require_once('../app/config/app.php');
\Slim\Slim::registerAutoloader();
 
 
/*====================== App Configuration =====================*/
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


/*====================== App Route Configuration =====================*/
// User id from db - Global Variable
$user_id = NULL;
 
$app->get('/', function() use ($app) {
    $response = array();
    $response['message'] = 'Aloha mundo desde '.API_FULLNAME;
    echoRespnse(200, $response);
});// root


$app->notFound(function () use ($app) {
    //$app->render('404.html');
    $response = array();
    $response['message'] = '404 no found here';
    echoRespnse(404, $response);
});

require_once('../app/route.php');
//run the app
$app->run();

?>
