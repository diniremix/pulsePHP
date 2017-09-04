<?php
namespace app\libraries;
class Modules {

    private static $_modules =array(
        'config' => array(
            'constants',
            'databases'
        ),
        'paths' => array(
            'CONFIG_PATH'=> 'config',
            'LIBRARIES_PATH'=> 'libraries',
            'ROUTES_PATH'=> 'routes',
            'TEMPLATES_PATH'=> 'templates',
            'STORAGE_PATH'=> 'storage',
            'VENDOR_PATH'=> 'vendor',
            'SCHEME'=> 'scheme',
        ),
        'libraries' => array(
            //'databases',
            //'basicAuth',
            'errorCodes',
            //'pulseAcl',
            //'pulseLog',
            'rest',
            'sessions',
            'utils',

            //'socket',
            //'network',
        ),
        'vendor' => array(
            'Slim' => '/Slim/Slim/Slim.php',
            'redbean' => 'redbean/rb.php',
        ),
    );

    public static function registerModules(){
        $_config=self::$_modules['paths'];
        $_vendors=self::$_modules['vendor'];
        $_apps=self::$_modules['config'];
        $_libraries=self::$_modules['libraries'];

        foreach ($_vendors as $vendor) {
            $modfile = APP_ABSPATH.DIRECTORY_SEPARATOR.$_config['VENDOR_PATH'].DIRECTORY_SEPARATOR.$vendor;
            if(file_exists($modfile)){
                if(is_readable($modfile)){
                    require_once $modfile;
                }
            }
        }

        foreach ($_apps as $app) {
            $modfile = APP_ABSPATH.DIRECTORY_SEPARATOR.$_config['CONFIG_PATH'].DIRECTORY_SEPARATOR.$app.'.php';
            if(file_exists($modfile)){
                if(is_readable($modfile)){
                    require_once $modfile;
                }
            }
        }

        foreach ($_libraries as $module) {
            $modfile = APP_ABSPATH.DIRECTORY_SEPARATOR.$_config['LIBRARIES_PATH'].DIRECTORY_SEPARATOR.$module.'.php';
            if(file_exists($modfile)){
                if(is_readable($modfile)){
                    require_once $modfile;
                }
            }
        }
    }

    public static function loadRoutes(){
        $_routesDir=APP_ABSPATH.DIRECTORY_SEPARATOR.self::$_modules['paths']['ROUTES_PATH'];
        if($dh = opendir($_routesDir)){
            while(($file = readdir($dh)) !== false){
                $modroute=$_routesDir.DIRECTORY_SEPARATOR.$file;
                if(file_exists($modroute)){
                    if (preg_match('/php/i', $modroute)){
                        if(is_readable($modroute)){
                            if (($file != ".") && ($file != "..")){
                                require_once $modroute;
                            }
                        }
                    }
                }
            }
            closedir($dh);
        }
    }
}

?>
