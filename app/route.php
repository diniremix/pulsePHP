<?php 
require_once('config/app.php');
require_once('config/codeStatus.php');
require_once("rest.php");
class Route extends Rest{
	
	private static $postRoute;
	private static $getRoute;
	private static $inputRoute;
	private static $deleteRoute;
	private static $serverMethod;
	private static $callFunction;
	public static $status;

	public static function post($value=''){
		if (!empty($value)) {
			self::$postRoute[]=$value;
		}
	}

	public static function get($value=''){
		if (!empty($value)) {
			self::$getRoute[]=$value;
		}
	}

	public static function input($value=''){
		if (!empty($value)) {
			self::$inputRoute[]=$value;
		}
	}

	public static function delete($value=''){
		if (!empty($value)) {
			self::$deleteRoute[]=$value;
		}
	}

	public static function getRoutes($route){
		switch ($route) {
			case 'post':
				return self::$postRoute;
				break;
			case 'get':
				return self::$getRoute;
				break;
			case 'input':
				return self::$inputRoute;
				break;
			case 'delete':
				return self::$deleteRoutes;
				break;
			default:
				return null;
				break;
		}
	}

	private static function response($apiMsg,$errorCode = 400) {
		$errorMsg=$apiMsg.': '.self::$status[$errorCode];
		$responseMsg = array(  
		'status_code' => $errorCode,  
		'status_message' => $errorMsg); 
        header("Content-Type:" . TYPE_CONTENT . ';charset=utf-8');
        echo json_encode($responseMsg);
	}

	public static function startup() {
		if (isset($_REQUEST['url'])) {  
			$serverMethod=$_SERVER['REQUEST_METHOD'];
			$fullUrl = explode('/', trim($_REQUEST['url']));  
			$fullUrl = array_filter($fullUrl);  
			$getApi = strtolower(array_shift($fullUrl)); //saca el primer parametro, la version de api 
			if ($getApi==API_VERSION) {
				$metodo = strtolower(array_shift($fullUrl)); //saca el segundo parametro, el metodo 
				switch($serverMethod){
					case 'GET': 
						$metodo= self::getFunction($metodo,self::$getRoute,$fullUrl);
						break;
					case 'POST': 
						$metodo= self::$getFunction($metodo, self::$postRoute,$fullUrl);
						break;
					default:
						$metodo= 404;  
						break;
				}
				return self::response(APP_MSG,$metodo);  
			}else{
				return self::response(APP_ERROR,600);
			}
		}else{
			return self::response(APP_ERROR, 400);  
		}
	}

	public static function getFunction($method,$Routes,$url) {
		$call=602;
		if (in_array("/".$method, $Routes)) {
			self::$callFunction=PREFIX_FUNCTION.$method;
			if ((int) method_exists(__CLASS__, self::$callFunction) > 0) {  
				if (count($url) > 0) {  
					$call=call_user_func_array(array(__CLASS__,self::$callFunction), $url);
					return $call;  
				}else{
					$call=call_user_func(array(__CLASS__, self::$callFunction));
					return $call;  
				}  
			}else{
				$call=601;
				return $call;
			} 
		}else{
			return $call;  
		}
	}
}//class
Route::$status=$codeStatus;
?>
