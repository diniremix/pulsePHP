<?php 
/*=========== Route functions for user class ==========*/
/*This file is part of the PulsePHP, Be careful with this file */
/*
examples

GET     /apiVersion/user   Retrieve list of user
GET     /apiVersion/user/[_id] Retrieve a user
POST    /apiVersion/user   Create a new user
PUT     /apiVersion/user/[_id] Update an existing user
DELETE  /apiVersion/user/[_id] Delete a user
*/

$Users= $bc->createIntance('users',$app);
$user = new $Users();

$app->group('/api', function () use ($app) {
    $app->group(USE_API, function () use ($app) {
        $app->group('/users', function () use ($app) {
            $app->get('/',  function()  use ($app){
                global $user;
                $user->getAll($app,'users');
            });

            //CRUD START
            $app->get('/:id', function($item_id) use ($app){
                global $user;
                $user->getOne($app,$item_id);
            });

            $app->post('/', function()  use ($app){
                echoRespnse(0,DEFAULT_MESSAGE,'please using '.'/api'.USE_API.'/users/register instead this');
            });

            $app->put('/:id', function($item_id)  use ($app){
                echoRespnse(1006,DONT_HAVE_PERMISSION);
            });

            $app->delete('/:id', function($item_id)  use ($app){
                echoRespnse(1006,DONT_HAVE_PERMISSION);
            });        
            //CRUD END
        });
    });
});
?>