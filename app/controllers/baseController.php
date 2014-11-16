<?php 
class baseController {
	function __construct(){
		require_once (APP_ABSPATH.'../includes/database.php');
        Database::init();
	}

	function createIntance($class,$app){
		$model=APP_ABSPATH."../models/".strtolower($class).".php";
		$controllerName=strtolower($class)."Controller";
		$controller=APP_ABSPATH."../controllers/".$controllerName.".php";
		
		if(file_exists($model) && file_exists($controller)){
			include_once($model);
			include_once($controller);
			$newClass= "{$controllerName}";
			if (class_exists($newClass)) {
				return $newClass;
			}else{
				return NULL;
			}
		}else{
	        echoRespnse(802, MODEL_CONTROLLER_NOT_FOUND);
	        $app->stop();
		}
	}

	function getPropertiesClass(){
		$properties =array();
		$class_vars = get_class_vars(get_class($this));
		foreach ($class_vars as $name => $value) {
		    array_push($properties, $name);
		}
		return $properties;
	}
}
?>