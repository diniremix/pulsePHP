<?php
class pulseLog {
    
    public static function getIp(){
        if (isset($_SERVER["HTTP_CLIENT_IP"])){
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"])){
            return $_SERVER["HTTP_FORWARDED"];
        }
        else{
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    public static function register(){
        $userIp=self::getIp();
        if ($userIp!="::1") {
            $userId=Session::getSessionValue('userid');
            $fields = array('user_id' => $userId,'ip'=>$userIp);
            $dbo = new Database();
            $result =$dbo->save('log',$fields);
            return $result;
        }else{
            return NULL;
        }
    }
    
    public static function clear(){
        $dbo = new Database();
        $dbo->deleteAll('log');
    }
}
?>
