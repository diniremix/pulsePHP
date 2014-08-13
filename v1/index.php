<?php
require_once('../app/config/app.php');

/*====================== App Route Configuration =====================*/

$app->get('/', function() use ($app) {
    echoRespnse(0, 'Aloha mundo desde '.API_FULLNAME);
});// root


$app->notFound(function () use ($app) {
    //$app->render('404.html');
    echoRespnse(702, NOT_FOUND);
});

//run the app
$app->run();

?>
