<?php
namespace app\libraries;
use app\libraries\Utils;
class Rest {

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
            self::response(1005, "Invalid JSON value found",$decodedJson);
            $app->stop();
        }
    }

    /**
     * [Verifying required params posted or not]
     * @param  [array] $required_fields [fields to check]
     * @return [valid array fields or application error]
     */
    public static function verifyRequiredParams($required_fields) {
        $error = false;
        $error_fields = "";
        $request_params = array();
        $request_params = $_REQUEST;

        $app = \Slim\Slim::getInstance();
        $req= $app->request()->getBody();
        $request_params= self::isJSONData($req);

        if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
            $app = \Slim\Slim::getInstance();
            parse_str($app->request()->getBody(), $request_params);
                $request_params=self::isJSONData($request_params);
        }

        foreach ($required_fields as $field) {
            if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
                $error = true;
                $error_fields .= $field . ', ';
            }
        }

        if (!$error){
            foreach ($required_fields as $field){
                if (is_null(Utils::sanityCheck($request_params[$field]))){
                    $error = true;
                    $error_fields .= $field . ', ';
                }
            }
        }

        if ($error){
            // Required field(s) are missing or empty
            // echo error json and stop the app
            $app = \Slim\Slim::getInstance();
            self::response(1005, 'Required field(s) "' . substr($error_fields, 0, -2) . '" is missing or empty');
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
     * Echoing json response to client
     * @param Int $errorCode response code error
     * @param String $message response message title
     * @param Array $data Json response
     * @return [a json response]
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
}//Rest
