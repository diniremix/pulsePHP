<?php
/*=========== Route functions for Error codes ==========*/
/*This file is part of the PulsePHP, Be careful with this file */

$app->group('/api', function () use ($app) {
	$app->group(USE_API, function () use ($app) {
		
		$app->group('/errors', function () use ($app) {
			
			$app->get('/', function() use ($app) {
			    global $messages;
			    echoRespnse(0, 'Error Codes',$messages);
			});

			$app->get('/:id', function($error_id) {
			    global $messages;
			    if(array_key_exists($error_id, $messages)){
			        echoRespnse(0, 'Error Code: '.$error_id,$messages[$error_id]);
			    }else{
			        echoRespnse(1100,'Invalid code Error');
			    }
			});

		});
	});
});
?>
