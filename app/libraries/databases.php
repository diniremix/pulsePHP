<?php
require_once(APP_ABSPATH.'vendor/redbean/rb.php');

class Database extends RedBean_Facade{

	private static $connection=NULL;

	function __construct(){
        R::freeze(true);
    }

    public static function init(){
        global $databases;
		$dbDefault=strtolower($databases['DB_DEFAULT']);
        switch ($dbDefault) {
            case 'none':
                return NOT_USING_DATABASE;
                break;
            case 'mysql':
            case 'postgresql':
            case 'pgsql':
                self::$connection=$dbDefault.':host='.$databases[$dbDefault]['DB_HOST'].';dbname='.$databases[$dbDefault]['DB_NAME'];
                break;
            case 'cubrid':
                if(!defined('DB_PORT')){
                    return MISSING_PORT_NUMBER;
                }
                self::$connection=$dbDefault.':host='.$databases[$dbDefault]['DB_HOST'].';port='.$databases[$dbDefault]['DB_PORT'].';dbname='.$databases[$dbDefault]['DB_NAME'];
                break;
            case 'sqlite':
                self::$connection=$dbDefault.':'.STORAGE_PATH.$databases[$dbDefault]['DB_NAME'].SQLITE_EXT_FILE;
                break;
            default:
                self::$connection=NULL;
                break;
        }

        if(self::$connection!=NULL){
            if($dbDefault==='sqlite'){
                return self::setup(self::$connection);
            }else{
                return self::setup(self::$connection,$databases[$dbDefault]['DB_USERNAME'],$databases[$dbDefault]['DB_PASSWORD']);
            }
        }else{
            return DATABASE_DRIVER_NOT_ALLOWED;
        }
	}//init

    public function save($table,$dataStore){
        try{
            $record = R::dispense($table);
            $record->import($dataStore);
            $id = R::store($record);
            // Check for successful insertion
            if ($id>0) {
                return $id;
            } else {
                return NULL;
            }
        }
        catch( Exception $e ) {
            R::rollback();
        }
    }//save

    public function update($table, $dataStore) {
        $record = R::load($table,$dataStore['id']);

        if($record->id){
            $record->import($dataStore);
        }else{
            return NULL;
        }

        $id = R::store($record);

        if($id>0){
            return $id;
        }else{
            return NULL;
        }
    }//update

    public function delete($table, $id) {
        $record = R::load($table,$id);
        if($record->id){
            R::trash($record);
        }else{
            return NULL;
        }
        return DELETED_SUCCESSFULLY;
    }//delete

    public function deleteAll($table) {
        //Be very careful with this!
        R::wipe($table);
    }//deleteAll

    public static function execQuery($sqlQuery,$params=NULL) {
        $fn="exec";
        if (preg_match('/SELECT/i', $sqlQuery)>0){
            $fn="getAll";
        }
        $method="{$fn}";

        if(!is_array($params)){
            $result=R::$method($sqlQuery);
        }else{
            $result=R::$method($sqlQuery,$params);
        }

        if(is_array($result)){
            return $result;
        }else if($result>0){
            return QUERY_SUCCESSFULLY;
        }else{
            return NULL;
        }
    }//execQuery

    public function search($table,$id=NULL) {
        if($id!=NULL){
            if(is_int($id)){
                if($id>0){
                    $result = R::load($table,$id);
                }else{
                    return NULL;
                }
            }else{
                return NULL;
            }
        }else{
            //$result = R::findAndExport($table);
            $result = R::getAll('select * from '.$table);
        }

        if(!is_array($result)){
            return $result->export();
        }else{
            return $result;
        }
    }//search

    public function select($tables,$fields,$conds=NULL){
        $sql="SELECT ";
        $i=1;

        if(!is_array($fields)){
            $sql.='*';
        }else{
            $totField=count($fields);
            foreach($fields as $key => $value){
                $sql.=$value;
                if($i<$totField){
                    $sql.=', ';
                }else{
                    $sql.=' ';
                    break;
                }
                $i++;
            }
        }

        $i=1;
        if(!is_array($tables)){
            return MISSING_ARRAY_TABLENAMES;
        }else{
            $sql.=' FROM ';
            $tottables=count($tables);
            foreach($tables as $key => $value){
                $sql.=$value;
                if($i<$tottables){
                    $sql.=', ';
                }else{
                    $sql.=' ';
                    break;
                }
                $i++;
            }
        }
        if($conds){
            $sql.=' WHERE '.$conds;
        }

        $result = self::execQuery($sql);
        return $result;
    }//select
}
