<?php 
namespace app\libraries;
class Utils {

    /**
     * [isJSONData to evaluate for a valid JSON]
     * @param  [JSON]  $jsonData [JSON to validate]
     * @return [a valid JSON or application error]
     */
    public static function isJSONData($jsonData){
        $decodedJson = json_decode(stripslashes($jsonData), TRUE);
        if(json_last_error() == JSON_ERROR_NONE){
            return $decodedJson;
        }else{
            $app = \Slim\Slim::getInstance();
            echoRespnse(1005, "Invalid JSON value found",$decodedJson);
            $app->stop();
        }
    }

    /**
     * Validating email address
     */
    /**
     * [validateEmail Validating email address]
     * @param  [type]  $email
     * @param  boolean $stopApp [defines whether the application will be stopped]
     * @return [boolean]
     */
    public static function validateEmail($email) {
        $app = \Slim\Slim::getInstance();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echoRespnse(1003, EMAIL_FAILURE);
            $app->stop();
        }else{
            return true;
        }
    }

    /**
     * [gettimestamp generates a timestamp based on the date and time of the server]
     * @return [sring] [a timestamp]
     */
    public static function getTimeStamp(){
        return date("YmdHis");//ej: 20100525151036
    }

    /**
     * [deleteStorage description]
     * @param  [type] $extFiles [file extension to delete]
     */
    public static function deleteStorage($extFiles){
        $dir=STORAGE_PATH;
        if($dh = opendir($dir)){
            while(($file = readdir($dh))!== false){
                if(file_exists($dir.$file)){
                    if (preg_match("/$extFiles/i", $dir.$file)){
                        unlink($dir.$file);
                    }
                }
            }
            closedir($dh);
        }
    }

    /**
     * [templateExist description]
     * @param  [string] $page [name of page]
     * @return [bool]       [page exist or not]
     */
    public static function templateExist($page){
        if(file_exists(TEMPLATES_PATH.$page.TEMPLATES_EXT_FILE)){
            return true;
        }else{
            return false;
        }
    }
}//Utils
?>
