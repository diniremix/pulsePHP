<?php
/*=========== Main Route functions ==========*/
/*This file is part of the PulsePHP, Be careful with this file
* please do not create route functions in this file, use the router directory
*/

$routers=loadRoutes();
if ($routers!=null) {
    foreach ($routers as $router) {
        require_once($router);
    }
}
?>