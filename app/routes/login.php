<?php
/*=========== App Route functions ==========*/
/*This file is part of the PulsePHP, Be careful with this file */

$app->group('/api', function () use ($app) {
    $app->group(USE_API, function () use ($app) {
        $app->post('/login', function() use ($app) {
            // check for required params
            $fields = array('username', 'password');
            $formdata=verifyRequiredParams($fields);

            if (Auth::checkLogin($formdata)){
                $user = Auth::getUserById($formdata['username']);
                if (!is_null($user)){
                    Session::createSession($user);
                    Acl::createAcl('user_permission');
                    echoRespnse(0,DEFAULT_MESSAGE);
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
            $Users= $bc->createIntance('Users',$app);
            $user = new $Users();
            $fields_u = $user->getPropertiesClass();

            $Persons= $bc->createIntance('Persons',$app);
            $person = new $Persons();
            $fields_p = $person->getPropertiesClass();

            // check for required params
            $formDataU=verifyRequiredParams($fields_u);
            $formDataP=verifyRequiredParams($fields_p);

            // validating email address
            validateEmail($formDataP['email']);

            if (!Auth::isUserExists($formDataP['email'])) {
                //save form
                $dbo = new Database();
                $resultP=$dbo->save('persons',$formDataP);
                if ($resultP != NULL) {
                    //get password hash and generate api key
                    $keypass=Auth::getUserKey($formDataU);
                    $formDataU=array_merge($formDataU,$keypass);

                    //verify if person_id and role_id from formdata
                    $personId=array('person_id'=>$resultP);
                    $formDataU=array_merge($formDataU,$personId);
                    $roleId=array('role_id'=>2);
                    $formDataU=array_merge($formDataU,$roleId);

                    $resultU=$dbo->save('users',$formDataU);

                    if ($resultU != NULL) {
                        echoRespnse(0,USER_CREATED_SUCCESSFULLY);
                    }else{
                        echoRespnse(901,USER_CREATE_FAILED,$resultU);
                    }
                }else{
                    echoRespnse(901,USER_CREATE_FAILED,$resultP);
                }
            }else{
                // User with same email already existed in the db
                echoRespnse(900,USER_ALREADY_EXISTED);
            }
        });
    });
});

?>