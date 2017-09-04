<?php 
namespace app\config;
require_once(APP_ABSPATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'modules.php');

use app\libraries\Modules;
use app\libraries\Rest;

// register Modules for pulsePHP
Modules::registerModules();

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
        'log.enable' => true,
        'debug' => true,
        'templates.path' => './'.TEMPLATES_PATH
    ));
});


// Default Routes
$app->group('/', function () use ($app) {
    $app->map('/', function() use ($app){
        Rest::response(200, 'Aloha! from '.API_FULLNAME.', please using '.API_NAME.' instead root');
    })->via('GET', 'POST');
});

$app->group(API_NAME, function () use ($app) {
    $app->map('/', function() use ($app){
        Rest::response(200, 'This is '.API_FULLNAME.', codename: '.CODE_NAME);
    })->via('GET', 'POST');
});

$app->notFound(function () use ($app) {
    //$app->render('404.html');
    Rest::response(702, NOT_FOUND);
});

// finally load routes for pulsePHP
Modules::loadRoutes();

?>
