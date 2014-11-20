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

	function createUser($app){
		//vease '/register'
		$app->redirect('register');
	}

	function updateUser($app,$item_id){
		//except the password
		$id = preg_replace("/[^0-9]/", "", $item_id);
	    $id=(int)$id;
	    if($id>0){
		    $upd_user=verifyRequiredParams(array('name', 'username','email','status'));
	        // validating email address
	        validateEmail($upd_user['email']);
	        if (Auth::isUserExists($id)){
			    //add id of the user
			    $upd_user=array_merge($upd_user,array('id'=>$id));
			    // updating user
	        	$dbo = new Database();
			    $result = $dbo->update('users',$upd_user);
			    if ($result!=NULL) {
			        echoRespnse(0,'User updated successfully',$result);
			    }else{
			        // user failed to update
			        echoRespnse(1002,'User failed to update. Please try again!');
			    }
	        }else{
	            // User with the email not existed in the db
	            echoRespnse(900,'The requested User doesn\'t exists');
	        }
	    }else{
	        echoRespnse(701,RESOURCE_NOT_EXIST);
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