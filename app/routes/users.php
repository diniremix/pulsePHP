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

$app->group(USE_API, function () use ($app) {
    $app->group('/users', function () use ($app) {
        $app->get('/',  function()  use ($app){
            $users= array(
                array(
                "name"=>'Peter',
                "lastname"=>'Anderson',
                "role_id"=>22
                )
            );
            echoRespnse(0,DEFAULT_MESSAGE,$users);
        });

        $app->post('/',  function()  use ($app){
            $fields = array('username', 'password');
            $formdata=verifyRequiredParams($fields);
                $user= array(
                array(
                "name"=>'Peter',
                "lastname"=>'Anderson',
                "role_id"=>22,
                "gravatar"=>'api/users/images/image1.png',
                "role_name"=>'Software Developer',
                "creation_date"=>'2016-09-16 16:37:57',
                "specialization"=> array('Rest Api', 'PulsePHP'),
                "localization"=>array(4.6739405,-74.0800225),
                )
            );
            echoRespnse(0,DEFAULT_MESSAGE,$user);
        });

        //CRUD START
        $app->get('/:id', function($item_id) use ($app){
            echoRespnse(1006,DONT_HAVE_PERMISSION);
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
//});
?>