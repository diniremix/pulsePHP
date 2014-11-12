<?php
/*=========== Database Configuration ==========*/
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'taskfm');

define('DB_PORT', '3306');
define('DB_DEFAULT', 'mysql');
/*=========== App Configuration ==========*/
define('APP_ERROR','Application Error');
define('APP_MSG','Application Message');
define('APP_STAT','Application Status');
define('API_NAME','PulsePHP');
define('USE_API','/v1');
define('API_VERSION','v2.1.1');
define('API_FULLNAME',API_NAME.' '.API_VERSION);
//define('PREFIX_FUNCTION','fn_');

/*=========== content type Configuration ==========*/
define('CONTENT_JSON','application/json');
define('CONTENT_PDF','application/pdf');
define('CONTENT_XML','application/xml');
define('APP_TYPE_CONTENT_DEFAULT',CONTENT_JSON);

/*=========== messages ==========*/
define('EXPIRED_API_KEY', 'Access Denied. Api key is expired');
define('INVALID_API_KEY', 'Access Denied. Invalid Api key');
define('MISSSING_API_KEY', 'Api key is misssing');

define('USER_CREATED_SUCCESSFULLY', 'User created successfully');
define('USER_CREATE_FAILED', 'User create failed');
define('USER_ALREADY_EXISTED', 'User already existed');

define('DELETED_SUCCESSFULLY', 'Record deleted successfully');

define('QUERY_SUCCESSFULLY', 'Query executed successfully');
define('QUERY_FAILED', 'Query failed. Please try again!');

define('LOGIN_FAILED', 'Login failed. Incorrect credentials');

define('EMAIL_FAILURE', 'Email address is not valid');

define('DEFAULT_MESSAGE', 'Successfully!');
define('DEFAULT_ERROR_MESSAGE', 'An error occurred. Please try again!');
define('DEFAULT_DATA_CONTENT', 'No content available');

define('RESOURCE_NOT_EXIST', 'The requested resource doesn\'t exists');

define('MODEL_NOT_FOUND', 'Model not found');
define('CONTROLLER_NOT_FOUND', 'Controller not found');
define('MODEL_CONTROLLER_NOT_FOUND', 'Model or Controller not found');
define('NOT_FOUND', 'Not found here');
define('UNEXPECTED_ERROR', 'Unexpected Error');

?>
