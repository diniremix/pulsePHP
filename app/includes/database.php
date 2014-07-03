<?php
class Database extends RedBean_Facade{		
	
	private static $connection='';
	
	function __construct(){
		require_once(APP_ABSPATH.'Config.php');
		require_once(APP_ABSPATH.'../vendor/redbean/rb.php');
		R::freeze(true);
	}

	public static function init(){						
		$database_default=strtolower(DB_DEFAULT);
		switch ($database_default) {
			case 'mysql':
			case 'postgresql':
			case 'pgsql':
				self::$connection=$database_default.':host='.DB_HOST.';dbname='.DB_NAME;
				break;
			case 'cubrid':
				if(!defined('DB_PORT')){
					return 'Cubrid: Port number is required';
				}
				self::$connection=$database_default.':host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME;
				break;
			case 'sqlite':
				self::$connection=$database_default.':/app/storage/'.DB_NAME.'sqlite';
				break;
			default:
				return 'Error: Database driver not allowed';
				break;
		}
		return self::setup(self::$connection,DB_USERNAME,DB_PASSWORD);
	}
}
?>
