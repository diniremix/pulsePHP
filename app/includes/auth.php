<?php

class Auth{
 
    // blowfish
    private static $algo = '$2a';
    // cost parameter
    private static $cost = '$10';
 
    // mainly for internal use
    public static function unique_salt() {
        return substr(sha1(mt_rand()), 0, 22);
    }
 
    // this will be used to generate a hash
    public static function hash($password) {
 
        return crypt($password, self::$algo .
                self::$cost .
                '$' . self::unique_salt());
    }
 
    // this will be used to compare a password against a hash
    public static function check_password($hash, $password) {
        $full_salt = substr($hash, 0, 29);
        $new_hash = crypt($password, $full_salt);
        return ($hash == $new_hash);
    }

    /**
     * Generating random Unique SHA1 String for user Api key
     */
    public static function generateApiKey() {
        return sha1(uniqid(rand(), true));
    }

    /**
     * [generatePasswordHash generating random Unique SHA1 String for password ]
     * @param  [array] $fields [password to generate]
     * @return [string]         [sha1 hash]
     */
    public static function generatePasswordHash($fields) {
        $password=$fields['password'];
        $password_hash=md5($password.date("Y"));
        $hash=sha1($password_hash.date("Y"));
        return $hash;
    }

    /**
     * [getPasswordHash get password hash and generate a new api key]
     * @param  [type] $fields [array]
     * @return [array]
     */
    public static function getUserKey($fields){
        $password=self::generatePasswordHash($fields);
        $validKey=array();
        // Generating password hash
        $validKey['password'] = $password;
        $validKey['password_hash'] = self::hash($password);
        // Generating API key
        $validKey['api_key'] = self::generateApiKey();
        return $validKey;
    }

     /**
     * Checking user login
     * @param Array $fields Username or email login
     * @return boolean User login status success/fail
     */
    public static function checkLogin($fields) {
        // fetching user by email or username
        $query='SELECT password_hash FROM users WHERE ';
        $field=filter_var($fields['username'], FILTER_VALIDATE_EMAIL);
        if($field){
            $query.="email=";
        }else{
            $query.="username=";
        }
        $query.="'".$fields['username']."' LIMIT 1";
        
        $password_hash=R::getCell($query);

        // Found user with the email o username
        if ($password_hash) {
            $pass=self::generatePasswordHash($fields);
            // Now verify the password
            if (self::check_password($password_hash,$pass)) {
                // User password is correct
                return TRUE;
            } else {
                // user password is incorrect
                return FALSE;
            }
        } else {
            // user not existed with the email o username
            return FALSE;
        }
    }
   
    /**
     * [isValidApiKey Validating user api key
     * If the api key is there in db, it is a valid key]
     * @param  [String]  $api_key [user api key]
     * @return boolean          [description]
     */
    public static function isValidApiKey($api_key) {
        $isValid=R::getCell( 'SELECT id from users WHERE api_key = ?', array($api_key));
        if($isValid){
            return true;
        }else{
            return false;
        }
        //return $isValid > 0;
    }
    
    /**
     * [getUserId Fetching user id by api key]
     * @param  [String] $api_key [user api key]
     * @return [string] $user_id [user ID]
     */
    public static function getUserId($api_key) {
        $user_id=R::getCell( 'SELECT id FROM users WHERE api_key = ?', array($api_key));
        if($user_id){
            return $user_id;
        }else{
            return NULL;
        }
    }
}//class

/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $app = \Slim\Slim::getInstance();
    $response = array();
    
    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        $bc= new baseController();
        // get the api key
        $api_key = $headers['Authorization'];

        // validating api key
        if (Auth::isValidApiKey($api_key)) {
            global $user_id;
            // get user primary key id
            $userID = Auth::getUserId($api_key);
            if ($userID != NULL){
                $user_id = $userID;
            }else{
                $response["error"] = true;
                $response["message"] = "Access Denied. Api key is expired";
                echoRespnse(401, $response);
                $app->stop();
            }
        }else{
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(400, $response);
            $app->stop();
        }
    }else{
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoRespnse(400, $response);
        $app->stop();
    }
}
?>
