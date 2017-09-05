<?php
namespace app\libraries;
class Utils {

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
     * clean data from forms
     */
    public static function sanityCheck($values){
        $strip = strip_tags($values);
        $htmlentities = htmlentities($strip);
        if(empty($htmlentities)){
            return NULL;
        }
        return $htmlentities;
    }

    /**
     * [gettimestamp generates a timestamp based on the date and time of the server]
     * @return [sring] [a timestamp]
     */
    public static function getTimeStamp(){
        return date("YmdHis");//ej: 20100525151036
    }
}//Utils

/*******************************************************************************/
/**
 * Echoing json response to client
 * @param Int $errorCode response code error
 * @param String $message response message title
 * @param Array $data Json response
 */
function echoRespnse($errorCode,$message,$data=NULL) {
    $status_code=200;
    $response=array();

    if(!is_int($errorCode)){
        $response['status']=404;
    }else{
        $response['status']=$errorCode;
    }

    if(!is_array($message)){
        $response['message']=$message;
    }else{
        $response['message']=DEFAULT_MESSAGE;
    }

    if($data!=NULL){
        $response['data']=$data;
    }else{
        $response['data']=DEFAULT_DATA_CONTENT;
    }

    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType(APP_TYPE_CONTENT_DEFAULT);
    echo json_encode($response);
}

/**
 * DEPRECATED
 * [loadRoutes search for routes modules]
 * @return [array] [routes]
 */
function loadRoutes(){
    $dir=APP_PATH.ROUTES_APP;
    $routes=array();
    if($dh = opendir($dir)){
        while(($file = readdir($dh))!== false){
            if(file_exists($dir.$file)){
                if (preg_match('/php/i', $dir.$file)){
                    if (($file!=".") && ($file!="..")){
                        array_push($routes, $dir.$file);
                    }
                }
            }
        }
        closedir($dh);
    }
    return $routes;
}

/**
 * DEPRECATED
 * [loadRoutesOnDemand search for custom modules]
 * @param  [array] $routesFiles [modules array]
 * @return [array]              [modules array paths]
 */
function loadRoutesOnDemand($routesFiles){
    $dir=APP_PATH.ROUTES_APP;
    $appRoutes=array('application.php','errors.php');
    $routes=array();
    if($dh = opendir($dir)){
        foreach ($appRoutes as $appRoute) {
            if(file_exists($dir.$appRoute)){
                array_push($routes, $dir.$appRoute);
            }
        }
        foreach ($routesFiles as $file) {
            if(file_exists($dir.$file.".php")){
                array_push($routes, $dir.$file.".php");
            }
        }
        closedir($dh);
    }
    return $routes;
}

/**
 * [deleteStorage description]
 * @param  [type] $extFiles [file extension to delete]
 */
function deleteStorage($extFiles){
    $dir=STORAGE_APP;
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
function templateExist($page){
    if(file_exists(TEMPLATES_PATH.$page.TEMPLATES_EXT_FILE)){
        return true;
    }else{
        return false;
    }
}
