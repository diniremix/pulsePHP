<?php 
class usersController extends Users{

	function __construct(){
		# code...
	}

	function getAll($app){
        $dbo = new Database();
        $result = $dbo->search('users');
        if ($result != NULL) {
            echoRespnse(0,DEFAULT_MESSAGE,$result);
        }else{
            echoRespnse(701,RESOURCE_NOT_EXIST);
        }
	}
	
	function getOne($app,$item_id){
		$id = preg_replace("/[^0-9]/", "", $item_id);
	    $id=(int)$id;
	    if($id>0){
	        $dbo = new Database();
	        $result = $dbo->search('users',$id);
	        if ($result != NULL) {
	            echoRespnse(0,DEFAULT_MESSAGE,$result);
	        } else {
	            echoRespnse(701,RESOURCE_NOT_EXIST);
	        }
	    }else{
	        echoRespnse(701,RESOURCE_NOT_EXIST);
	    }
	}
}
?>