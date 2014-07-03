<?php 
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
	return $htmlentities;
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType(APP_TYPE_CONTENT);
    echo json_encode($response);
}

?>