<?php
/*=========== App Route functions ==========*/
/*This file is part of the PulsePHP, Be careful with this file */

class Session {

    public static function createSession($userSession){
        session_start();
        $_SESSION["username"] = $userSession['username'];
        $_SESSION["role"] = $userSession['role_id'];
        $_SESSION["api_key"] = $userSession['api_key'];
    }

    public static function verifySession(){
        session_start(); 
        if( !isset($_SESSION['username']) && !isset($_SESSION['role']) 
            && !isset($_SESSION['api_key'])) { 
            return false;
        }else{
            return true;
        }
    }

    public static function deleteSession(){
        session_start();
        session_unset();
        session_destroy();
    }

    public static function getUserSession(){
        return $_SESSION;
    }

    public static function setSessionValue($name, $value){
        $_SESSION[$name] = $value;
    }

    public static function getSessionValue($name){
        return $_SESSION[$name];
    }
}

?>