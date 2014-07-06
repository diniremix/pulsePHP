<?php
require_once(APP_ABSPATH.'../vendor/redbean/rb.php');

class Database extends RedBean_Facade{		
	
	private static $connection='';
	
	function __construct(){
		require_once(APP_ABSPATH.'Config.php');
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

	public function save($table,$dataStore){
		try{
			$record = R::dispense($table);
			foreach ($dataStore as $key=>$values) {
				$record->{$key}=$values;
			}		
			$id = R::store($record);
	    	return $id;
		}
		catch( Exception $e ) {
			R::rollback();
	    	//return $e;
		}
	}

	/**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
    private function isUserExists($email) {
        $stmt = $this->conn->prepare("SELECT id from users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
}
?>
