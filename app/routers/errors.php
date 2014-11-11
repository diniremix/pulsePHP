<?php
/*=========== Route functions for Error codes ==========*/
/*This file is part of the PulsePHP, Be careful with this file */

$app->get('/errors', function() use ($app) {
    global $messages;
    echoRespnse(0, 'Error Codes',$messages);
});

$app->get('/errors/:id', function($error_id) {
    global $messages;
    if(array_key_exists($error_id, $messages)){
        echoRespnse(0, 'Error Code: '.$error_id,$messages[$error_id]);
    }else{
        echoRespnse(1100,'Invalid code Error');
    }
});
?>