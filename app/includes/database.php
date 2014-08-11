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
                return $id;//USER_CREATED_SUCCESSFULLY;
            } else {
            	// Failed to create user
            	return -1;//USER_CREATE_FAILED;
            }
		}
		catch( Exception $e ) {
			R::rollback();
	    	//return $e;
		}
	}

    public function update($table, $dataStore) {
        $record = R::load($table,$dataStore['id']);

        if($record->id){
            foreach ($dataStore as $key=>$values) {
                $record->{$key}=$values;
            }
        }else{
            return NULL;
        }

        $id = R::store($record);

        if($id>0){
            return $id;
        }else{
            return NULL;
        }
    }

    public function delete($table, $id) {
        $record = R::load($table,$id);
        if($record->id){
            R::trash($record);
        }else{
            return NULL;
        }
        return "OK";
    }

    public function deleteAll($table) {
        //Be very careful with this!
        R::wipe($table);
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
    }

    /**
     * Creating new task
     * @param String $user_id user id to whom task belongs to
     * @param String $task task text
     */
    public function createTask($user_id, $task) {        
        $new_task_id=self::save('tasks',$task);
        if($new_task_id>0){
            $result=self::createUserTask($user_id, $new_task_id);
            if($result){
                return $new_task_id;
            }else{
                return NULL;
            }
        }else{
            return NULL;
        }
    }

    /**
     * Function to assign a task to user
     * @param String $user_id id of the user
     * @param String $task_id id of the task
     */
    public function createUserTask($user_id, $task_id) {
        //$user_tasks= array();
        //$user_tasks['user_id']=$user_id;
        //$user_tasks['task_id']=$task_id;
        //$result=self::save('user_tasks',$user_tasks);
        $result=R::exec( 'INSERT INTO user_tasks(user_id, task_id) values(?, ?)', array($user_id,$task_id));
        return $result;
    }

    /**
     * Fetching single task
     * @param String $task_id id of the task
     * @param String $user_id id of the user
     */
    public function getTask($task_id, $user_id) {
        $task=R::getRow('SELECT t.id, t.task, t.status, t.created_at from tasks t, user_tasks ut WHERE t.id = ? AND ut.task_id = t.id AND ut.user_id = ?',array($task_id, $user_id));
        if ($task){
            return $task;
        } else {
            return NULL;
        }
    }
}
?>
