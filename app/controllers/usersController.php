<?php
class usersController extends Users{

	function __construct(){
		# code...
	}

	function getAll($app,$table){
	        $dbo = new Database();
	        $result = $dbo->search($table);
	        if ($result != NULL) {
	            echoRespnse(0,DEFAULT_MESSAGE,$result);
	        }else{
	            echoRespnse(701,RESOURCE_NOT_EXIST);
	        }
	}

	function getOne($app,$item_id){
		$item=sanityCheck($item_id);
		$id=(int)$item;

		$dbo = new Database();
		if($id>0){
			$result = $dbo->search('users',$id);
			if ($result != NULL) {
				echoRespnse(0,DEFAULT_MESSAGE,$result);
			} else {
				echoRespnse(701,RESOURCE_NOT_EXIST);
			}
		}else{
			$cond="username='".$item."'";
			$result=$dbo->select(array('users'),NULL,$cond);
			if ($result != NULL) {
				echoRespnse(0,DEFAULT_MESSAGE,$result);
			} else {
				echoRespnse(701,RESOURCE_NOT_EXIST);
			}
		}
	}

	function getToken($app,$item_id){
		$item=sanityCheck($item_id);
		$id=(int)$item;

		$dbo = new Database();
		if($id>0){
			$result = $dbo->search('users',$id);
			if ($result != NULL) {
				echoRespnse(0,DEFAULT_MESSAGE,$result);
			} else {
				echoRespnse(701,RESOURCE_NOT_EXIST);
			}
		}else{
			$cond="username='".$item."'";
			$result=$dbo->select(array('users'),NULL,$cond);
			if ($result != NULL) {
				echoRespnse(0,DEFAULT_MESSAGE,$result);
			} else {
				echoRespnse(701,RESOURCE_NOT_EXIST);
			}
		}
	}

	function deleteUser($app,$item_id){
	    $id = preg_replace("/[^0-9]/", "", $item_id);
	    $id=(int)$id;
	    if($id>0){
	    	$dbo = new Database();
		    $result = $dbo->delete('users',$id);
		    if ($result!=NULL) {
		        echoRespnse(0,DEFAULT_MESSAGE,$result);
		    } else {
		        echoRespnse(1002,QUERY_FAILED,$result);
		    }
		}else{
	        echoRespnse(701,RESOURCE_NOT_EXIST);
	    }
	}
}
?>