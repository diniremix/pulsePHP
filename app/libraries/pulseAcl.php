<?php

class Acl {
    private static $nameAcl;
        
    function __construct($newAcl) {
        //$_SESSION["perms"] = $site_pages;
    }

    public static function createAcl($newAcl){

        self::$nameAcl=$newAcl;
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
        $perm=self::$nameAcl;
        if(in_array($page, $perms['user_permission'])){
            return true;
        }else{
            return false;
        }
    }
}

?>