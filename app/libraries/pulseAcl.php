<?php
namespace app\libraries;
use app\libraries\Session;
class Acl {

    public static function createAcl($newAcl){
        $role=Session::getSessionValue('role');
        $dbo = new Database();
        $cond="role_id=".$role;
        $permission=$dbo->select(array('view_role_permissions'),array('permission'),$cond);
        $px = array();
        foreach ($permission as $key => $perm) {
            foreach ($perm as $value) {
                array_push($px,$value);
            }
        }
        Session::setSessionValue($newAcl,$px);
    }

    public static function hasPermissions($page){
        $perms=Session::getUserSession();
        if(in_array($page, $perms['user_permission'])){
            return true;
        }else{
            return false;
        }
    }
}//Acl
