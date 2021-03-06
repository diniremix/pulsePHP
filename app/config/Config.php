<?php
/*=========== App Configuration ==========*/
date_default_timezone_set("America/Bogota");

define('API_NAME','PulsePHP');
define('USE_API','/v1');
define('API_VERSION','v2.1.6');
define('API_FULLNAME',API_NAME.' '.API_VERSION);
define('ROUTES_APP','routes/');
define('STORAGE_APP','app/storage/');
define('SQLITE_EXT_FILE','.sqlite');
define('USER_DEFAULT_TABLE','users');
define('USE_ONLY_API',TRUE);

define('APP_ERROR','Application Error');
define('APP_MSG','Application Message');
define('APP_STAT','Application Status');

define('GITHUB_URL_APP','https://github.com/diniremix/pulsePHP');
define('TEMPLATES_PATH','templates/');
define('TEMPLATES_EXT_FILE','.html');

/*=========== content type Configuration ==========*/
define('CONTENT_JSON','application/json');
define('CONTENT_PDF','application/pdf');
define('CONTENT_XML','application/xml');
define('APP_TYPE_CONTENT_DEFAULT',CONTENT_JSON);

/*=========== Database messages ==========*/
define('DATABASE_DRIVER_NOT_ALLOWED', 'Error: Database driver not allowed');
define('NOT_USING_DATABASE', 'Not using a Database');
define('MISSING_ARRAY_FIELDS', 'Array field(s) is missing');
define('MISSING_ARRAY_TABLENAMES', 'Array table name(s) is missing');
define('MISSING_PORT_NUMBER', 'Cubrid: Port number is required');

/*=========== API messages ==========*/
define('PUBLIC_KEY_TOKEN', 'public_key');
define('EXPIRED_API_KEY', 'Access Denied. Api key is expired');
define('INVALID_API_KEY', 'Access Denied. Invalid Api key');
define('MISSING_API_KEY', 'Api key is missing');

/*=========== general messages ==========*/
define('USER_CREATED_SUCCESSFULLY', 'User created successfully');
define('USER_UPDATED_SUCCESSFULLY', 'User updated successfully');
define('USER_CREATE_FAILED', 'User create failed');
define('USER_UPDATED_FAILED', 'User updated failed');
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
define('NON_AUTHORITATIVE_INFORMATION', 'Non-Authoritative Information');
define('DONT_HAVE_PERMISSION', 'you don\'t have permission to access the requested resource');

define('MODEL_NOT_FOUND', 'Model not found');
define('CONTROLLER_NOT_FOUND', 'Controller not found');
define('MODEL_CONTROLLER_NOT_FOUND', 'Model or Controller not found');
define('NOT_FOUND', 'Not found here');
define('UNEXPECTED_ERROR', 'Unexpected Error');

?>
