<?php
/*=========== Route functions for Error codes ==========*/
/*This file is part of the PulsePHP, Be careful with this file */
use app\libraries\Rest;
use app\libraries\Errors;
$app = \Slim\Slim::getInstance();

$app->group(API_NAME, function () use ($app) {
	$app->group('/errors', function () use ($app) {
		$app->get('/', function() use ($app) {
			$messages = Errors::allErrors();
		    Rest::response(200, 'Error Codes',$messages);
		});

		$app->get('/:id', function($error_id) {
			$message = Errors::getOne($error_id);
			Rest::response(200, $message);
		});
	});
});
