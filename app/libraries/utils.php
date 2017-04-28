<?php 
/**
 * [isJSONData to evaluate for a valid JSON]
 * @param  [JSON]  $jsonData [JSON to validate]
 * @return [a valid JSON or application error]
 */
function isJSONData($jsonData){
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
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;

    $app = \Slim\Slim::getInstance();
    $req= $app->request()->getBody();
    $request_params= isJSONData($req);

    if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
            $request_params=isJSONData($request_params);
    }

    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if (!$error){
        foreach ($required_fields as $field){
            if (is_null(sanityCheck($request_params[$field]))){
                $error = true;
                $error_fields .= $field . ', ';
            }            
        }
    }

    if ($error){
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $app = \Slim\Slim::getInstance();
        echoRespnse(1005, 'Required field(s) "' . substr($error_fields, 0, -2) . '" is missing or empty');
        $app->stop();
    }else{
        //return form values
        $formdata=array();
        foreach ($required_fields as $value) {
            $formdata[$value] = $request_params[$value];
        }
        return $formdata;
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
function validateEmail($email) {
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
function sanityCheck($values){
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
function getTimeStamp(){
    return date("YmdHis");//ej: 20100525151036
}

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
 * [loadRoutes search for routes modules]
 * @return [array] [routes]
 */
function loadRoutes(){
    $dir=APP_ABSPATH.ROUTES_APP;
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
 * [loadRoutesOnDemand search for custom modules]
 * @param  [array] $routesFiles [modules array]
 * @return [array]              [modules array paths]
 */
function loadRoutesOnDemand($routesFiles){
    $dir=APP_ABSPATH.ROUTES_APP;
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

?>
