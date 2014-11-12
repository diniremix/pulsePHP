<?php
/*=========== App Route functions ==========*/
/*This file is part of the PulsePHP, Be careful with this file */

$app->group(USE_API, function () use ($app) {
    
    $app->post('/login', function() use ($app) {
        // check for required params
        $fields = array('username', 'password');
        $formdata=verifyRequiredParams($fields);

        if (Auth::checkLogin($formdata)){
            $user = Auth::getUserById($formdata['username']);
            if (!is_null($user)){
                echoRespnse(0,DEFAULT_MESSAGE,$user);
            }else{
                // unknown error occurred
                echoRespnse(1004,DEFAULT_ERROR_MESSAGE);
            }
        }else{
            // user credentials are wrong
            echoRespnse(1001,LOGIN_FAILED);
        }
    });

    $app->post('/register', function() use ($app) {
        global $bc;
        $users= $bc->createIntance('users',$app);
        $user = new $users();
        $fields = $user->getPropertiesClass();
        
        // check for required params
        $formdata=verifyRequiredParams($fields);
        // validating email address
        validateEmail($formdata['email']);

        if (!Auth::isUserExists($formdata['email'])) {
            //get password hash and generate api key
            $key=Auth::getUserKey($formdata);
            $formdata=array_merge($formdata,$key);
            //save form
            $dbo = new Database();
            $result=$dbo->save('users',$formdata);
            
            if ($result != NULL) {
                echoRespnse(0,USER_CREATED_SUCCESSFULLY,$result);
            }else{
                echoRespnse(901,USER_CREATE_FAILED);
            }
        }else{
            // User with same email already existed in the db
            echoRespnse(900,USER_ALREADY_EXISTED);
        }
    });

});
?>