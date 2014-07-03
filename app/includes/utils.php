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

?>