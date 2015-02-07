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

$app->group(USE_API, function () use ($app) {
    $app->group('/users', function () use ($app) {
        
        $app->get('/', 'Auth::authenticate', function()  use ($app){
            global $user;
            $user->getAll($app);
        });

        $app->get('/:id', 'Auth::authenticate',function($item_id) use ($app){
            global $user;
            $user->getOne($app,$item_id);
        });

        $app->post('/', 'Auth::authenticate', function()  use ($app){
            //echoRespnse(0, 'ejemplo de api /v1/user/id put');// actualizar
            global $user;
            $user->createUser($app);
        });

        $app->put('/:id', 'Auth::authenticate', function($item_id)  use ($app){
            global $user;
            $user->updateUser($app,$item_id);
        });

        $app->delete('/:id', 'Auth::authenticate', function($item_id)  use ($app){
            global $user;
            $user->deleteUser($app,$item_id);
        });        
    });
});
?>