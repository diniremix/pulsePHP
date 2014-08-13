<?php 
class baseController extends Database{

	function __construct(){
		require_once (APP_ABSPATH.'../includes/database.php');
        //require_once (APP_ABSPATH.'../includes/PassHash.php');
        $db= Database::init();
	}

	function createIntance($class){
		$model=APP_ABSPATH."../models/".strtolower($class).".php";
		$controllerName=strtolower($class)."Controller";
		$controller=APP_ABSPATH."../controllers/".$controllerName.".php";
		
		if(file_exists($model) ||file_exists($controller)){
			include_once($model);
			include_once($controller);
			$newClass= "{$controllerName}";
			if (class_exists($newClass)) {
			    //$objClass = new $newClass();
				//return $objClass;
				return $newClass;
			}else{
				return NULL;
			}
		}else{
	        echoRespnse(802, MODEL_CONTROLLER_NOT_FOUND);
	        //$app->stop();
		}
	}

	function getPropertiesClass($class){
		return $class->name.'::'.$class->email.'::'.$class->password;
	}
}
?>