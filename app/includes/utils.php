<?php 
/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
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
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }else{
        //return form values
        $formdata=array();
        foreach ($required_fields as $value) {
            //$formdata[$value] = sanityCheck($request_params[$value]);
            $formdata[$value] = $request_params[$value];
        }
        return $formdata;
    }
}

/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoRespnse(400, $response);
        $app->stop();
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
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code,$response) {
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType(APP_TYPE_CONTENT);
    echo json_encode($response);
}

?>