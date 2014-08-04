<?php 
/*=========== App Configuration ==========*/

define('APP_ERROR','Application Error');
define('APP_MSG','Application Message');
define('APP_STAT','Application Status');
define('API_NAME','PulsePHP');
define('API_VERSION','v1');
define('API_FULLNAME',API_NAME.' '.API_VERSION);
//define('PREFIX_FUNCTION','fn_');
define('APP_TYPE_CONTENT','application/json');
define('APP_ABSPATH', dirname(__FILE__).'/');

require_once(APP_ABSPATH.'Config.php');
require_once(APP_ABSPATH.'../includes/utils.php');
require_once(APP_ABSPATH.'../includes/auth.php');
require_once(APP_ABSPATH.'../includes/database.php');
require_once(APP_ABSPATH.'../controllers/baseController.php');
//require_once(APP_ABSPATH.'../../app/route.php');
require '../app/vendor/Slim/Slim.php';
?>
