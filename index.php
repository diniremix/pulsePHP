<?php
define('APP_ABSPATH', dirname(__FILE__).'/app/');
require_once(APP_ABSPATH.'config/app.php');
require_once(APP_ABSPATH.'route.php');
/*====================== App Route Configuration =====================*/

$app->group('/', function () use ($app) {
    $app->map('/',  function()  use ($app){
    	echoRespnse(0, 'Aloha! from '.API_FULLNAME.' please using '.API_NAME.USE_API.' instead root');
    })->via('GET', 'POST');
});

$app->group(USE_API, function () use ($app) {
    $app->map('/',  function()  use ($app){
		echoRespnse(0, 'Aloha! from '.API_FULLNAME);
	})->via('GET', 'POST');
});

$app->notFound(function () use ($app) {
    //$app->render('404.html');
    echoRespnse(702, NOT_FOUND);
});

//run the app
$app->run();

?>
