<?php
require_once('config/database.php');
require_once('vendor/redbean/rb.php');
class Rest extends RedBean_Facade{		
	
		private static $connection='';
		
		function __construct(){
			
		}
		public static function init(){
			if(empty($database_default)){
				return 'Error: Database driver is required'; 
			}
			if(empty($db_host)){
				return 'Error: Hostname is required';
			}
			if(empty($db_user)){
				return 'Error: Username is required';
			}
			if(empty($db_name)){
				return 'Error: Database name is required';
			}
						
			$database_default=strtolower($database_default);
			$database_default=$database_default?'postgresql':'pgsql';
			switch ($database_default) {
				case 'mysql':
				case 'postgresql':
				case 'pgsql':
					self::$connection=$database_default.':host='.$db_host.';dbname='.$db_name;
					break;
				case 'cubrid':
					if(empty($db_port)){
						return 'Cubrid: Port number is required';
					}
					self::$connection=$database_default.':host='.$db_host.';port='.$db_port.';dbname='.$db_name;
					break;
				case 'sqlite':
					self::$connection=$database_default.':/app/storage/'.$db_name.'sqlite';
					break;
				default:
					return 'Error: Database driver not allowed';
					break;
			}
			Rest::setup(self::$connection,$db_user,$db_pass);
		}
		
		/*=========== user-defined functions ==========*/
		public static function fn_usuarios($dataStore=null) {
			return 202;
		}
		
		/*function __autoload($nombre_clase) {
		    include "controllers/".$nombre_clase;
		}*/

		public static function fn_personas($dataStore=null) {
			$className=strtolower($dataStore)."Controller.php";
			$clase=$className;
			include_once("controllers/".$className);
			
			//$nombre_del_objeto = "Producto";
			//$nombre_de_la_nueva_clase = "{$nombre_del_objeto}Collection";
			//eval("class $nombre_de_la_nueva_clase extends CollectorObject {};");
			$nombre_del_objeto = $className;
			$nombre_de_la_nueva_clase = "{$nombre_del_objeto}";
			eval("class $nombre_de_la_nueva_clase extends Rest {};");

		    $mi_clase = new $nombre_de_la_nueva_clase();
		    //$mi_clase = new personaController();
			return $mi_clase->run();

    		if (class_exists("controllers/".$className)) {
			    $mi_clase = new $clase();
				return $mi_clase->run();
			}else{
				return 404;
			}
			//return 404;
			//$class->run();
			//isset($class);
		}
}
?>
