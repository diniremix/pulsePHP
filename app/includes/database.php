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
	    	// Check for successful insertion
            if ($id>0) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
            	// Failed to create user
            	return USER_CREATE_FAILED;
            }
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
    public function isUserExists($email) {
    	$UserExist=R::getCell( 'SELECT id from users WHERE email = ?', array($email));
        return $UserExist > 0;
    }

    /**
     * Fetching user by email or username
     * @param String $fields User email or username id
     */
    public function getUserById($fields) {
        $query='SELECT name, username, email, api_key, status, created_at FROM users WHERE ';
        $field=filter_var($fields, FILTER_VALIDATE_EMAIL);
        if($field){
            $query.="email=";
        }else{
            $query.="username=";
        }
        $query.="'".$fields."' LIMIT 1";
        $user=R::getRow($query);

        if ($user){
            return $user;
        } else {
            return NULL;
        }
    }

    

/*====================== Tasks =====================*/

    /**
     * Fetching all user tasks
     * @param String $user_id id of the user
     */
    public function getAllUserTasks($user_id) {
    	$task=R::getAll( 'SELECT t.* FROM tasks t, user_tasks ut WHERE t.id = ut.task_id AND ut.user_id = ?', 
            array($user_id) 
        );
        if ($task){
            return $task;
        }else{
            return NULL;
        }
        /*$stmt = $this->conn->prepare("SELECT t.* FROM tasks t, user_tasks ut WHERE t.id = ut.task_id AND ut.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;*/
    }
}
?>
