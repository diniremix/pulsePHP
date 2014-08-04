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
     * Generating random Unique MD5 String for user Api key
     */
    public static function generateApiKey() {
        return md5(uniqid(rand(), true));
    }

    /**
     * [getPasswordHash get password hash and generate a new api key]
     * @param  [type] $password [the password]
     * @return [array]
     */
    public static function getUserKey($password){
        $validKey=array();
        // Generating password hash
        $validKey['password_hash'] = self::hash($password);
        // Generating API key
        $validKey['api_key'] = self::generateApiKey();
        return $validKey;
    }

     /**
     * Checking user login
     * @param String $email User login email id
     * @param String $password User login password
     * @return boolean User login status success/fail
     */
    //public function checkLogin($email, $password) {
    public static function checkLogin($fields) {
        // fetching user by email
        $password_hash=R::getCell( 'SELECT password_hash FROM users WHERE email = ?', 
            array($fields['email']) 
        );

        if ($password_hash) {
            // Found user with the email
            // Now verify the password
            if (self::check_password($password_hash, $fields['password'])) {
                // User password is correct
                return TRUE;
            } else {
                // user password is incorrect
                return FALSE;
            }
        } else {
            // user not existed with the email
            return FALSE;
        }
    }

    /**
     * Validating user api key
     * If the api key is there in db, it is a valid key
     * @param String $api_key user api key
     * @return boolean
     */
    public static function isValidApiKey($api_key) {
        $isValid=R::getRow( 'SELECT id from users WHERE api_key = ?', array($api_key));
        if($isValid){
            return true;
        }else{
            return false;
        }
        //return $isValid > 0;

        /*$stmt = $this->conn->prepare("SELECT id from users WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;*/
    }

    /**
     * Fetching user id by api key
     * @param String $api_key user api key
     */
    public static function getUserId($api_key) {
        $user_id=R::getCell( 'SELECT id FROM users WHERE api_key = ?', array($api_key));
        if($user_id){
            return $user_id;
        }else{
            return NULL;
        }


        /*$stmt = $this->conn->prepare("SELECT id FROM users WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        if ($stmt->execute()) {
            $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }*/
    }

}//class

/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
 
    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        //$db = new DbHandler();
 
        // get the api key
        $api_key = $headers['Authorization'];
        // validating api key
        if (Auth::isValidApiKey($api_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(401, $response);
            //$app->stop();
        }else{
            global $user_id;
            // get user primary key id
            $userID = Auth::getUserId($api_key);
            //is_null(var)
            if ($userID != NULL){
                $user_id = $userID;
                //$user_id = $user["id"];
            }
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoRespnse(400, $response);
        //$app->stop();
    }
}
?>
