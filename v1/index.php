<?php
require_once('../app/config/app.php');
require_once(APP_ABSPATH.'../route.php');
/*====================== App Route Configuration =====================*/

$app->map(USE_API, function() use ($app) {
    echoRespnse(0, 'Aloha mundo desde '.API_FULLNAME);
})->via('GET', 'POST');// root

$app->notFound(function () use ($app) {
    //$app->render('404.html');
    echoRespnse(702, NOT_FOUND);
});

//run the app
$app->run();

?>
