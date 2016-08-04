<?php
class Errors {
    private static $_messages = array(
        //api error
        200=>'Successfully',
        600=>'API version not available',
        601=>'Application Error',
        602=>'Api Key is expired',
        603=>'Invalid Api Key',
        604=>'Api Key is missing',
        //
        700=>'Unexpected Error',
        701=>'No content available',
        702=>'The requested resource doesn\'t exists',
        //
        800=>'Model not found',
        801=>'Controller not found',
        802=>'Model or Controller not found',
        //
        900=>'User already existed',
        901=>'User create failed',
        //
        1000=>'Default error message',
        1001=>'Login failed. Incorrect credentials',
        1002=>'Query failed. Please try again',
        1003=>'Email address is not valid',
        1004=>'An error occurred. Please try again',
        1005=>'Required fields are empty or missing',
        1006=>'you don\'t have permission to access the requested resource',
        1100=>'Invalid code Error',
    );

    public static function allErrors(){
        return self::$_messages;
    }

    public static function getOne($_id){
        if(array_key_exists($_id, self::$_messages)){
            return self::$messages[$_id];
        }else{
            return INVALID_CODE_ERROR;
        }
    }
}
?>
