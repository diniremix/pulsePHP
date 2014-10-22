<?php 
//class baseController extends Database{
class baseController {
	function __construct(){
		require_once (APP_ABSPATH.'../includes/database.php');
        //require_once (APP_ABSPATH.'../includes/PassHash.php');
        $db= Database::init();
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
			    //$objClass = new $dnewClass();
				//return $objClass;
				return $newClass;
			}else{
				return NULL;
			}
		}else{
	        echoRespnse(802, MODEL_CONTROLLER_NOT_FOUND);
	        $app->stop();
		}
	}

	function getPropertiesClass(/*$class*/){
		$properties =array();
		//$class_vars=get_object_vars($this);
		$class_vars = get_class_vars(get_class($this));
		foreach ($class_vars as $name => $value) {
		    array_push($properties, $name);
		}
		/* 
		using ReflectionClass
		$reflect = new ReflectionClass($this);
		$props   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC ||ReflectionProperty::IS_PRIVATE||ReflectionProperty::IS_PROTECTED);
		
		foreach ($props as $prop) {
			$prop->setAccessible(true);
		    array_push($properties, $prop->getName());
		}
		*/
		return $properties;
	}
}
?>