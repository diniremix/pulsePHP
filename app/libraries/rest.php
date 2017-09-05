<?php
namespace app\libraries;
class Rest {

    /**
     * Verifying required params posted or not
     */
    public static function verifyRequiredParams($required_fields) {
        $error = false;
        $error_fields = "";
        $request_params = array();
        $request_params = $_REQUEST;

        if(isset($_REQUEST['jsonData'])){
            $request_params=isJSONData($_REQUEST['jsonData']);
        }else{
            // Handling PUT request params
            if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
                $app = \Slim\Slim::getInstance();
                parse_str($app->request()->getBody(), $request_params);
                if(isset($request_params['jsonData'])){
                    $request_params=isJSONData($request_params['jsonData']);
                }
            }
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
     * Echoing json response to client
     * @param Int $errorCode response code error
     * @param String $message response message title
     * @param Array $data Json response
     */
    public static function response($statusCode,$message,$data=NULL) {
        $status_code=200;
        $response=array();

        if(!is_int($statusCode)){
            $response['status']=404;
        }else{
            $response['status']=$statusCode;
        }

        if(!is_array($message)){
            $response['message']=$message;
        }else{
            $response['message']=DEFAULT_MESSAGE;
        }

        if($data!=NULL){
            $response['data']=$data;
        }else{
            $response['data']=[];
        }

        $app = \Slim\Slim::getInstance();
        $app->status($status_code);
        $app->contentType(APP_TYPE_CONTENT_DEFAULT);
        echo json_encode($response);
    }
}//Utils
