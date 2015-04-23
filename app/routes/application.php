<?php
/*=========== App Route functions ==========*/
/*This file is part of the PulsePHP, Be careful with this file */

if(USE_ONLY_API){
    $app->group('/', function () use ($app) {
        $app->map('/', function() use ($app){
            echoRespnse(0, 'Aloha! from '.API_FULLNAME.' please using '.'/api'.USE_API.' instead root');
        })->via('GET', 'POST');
    });
}

$app->group('/api', function () use ($app) {
    $app->map('/', function() use ($app){
         echoRespnse(0, 'Aloha! from '.API_FULLNAME.' current version api: '.USE_API);
    })->via('GET', 'POST');

    $app->group(USE_API, function () use ($app) {
        $app->map('/',  function()  use ($app){
            echoRespnse(0, 'This is the version "'.USE_API.'" of '.API_FULLNAME.', for more info visit: '.GITHUB_URL_APP);
        })->via('GET', 'POST');
    });
});

$app->notFound(function () use ($app) {
    //$app->render('404.html');
    echoRespnse(702, NOT_FOUND);
});

?>
