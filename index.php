<?php
    //session_start();
    include_once("helper/ManejoSesiones.php");

    include_once ("Configuration.php");
   $router = Configuration::getRouter();
//$router = new Router("UsuarioController", "vistaLogin");

    $controller = isset($_GET["controller"]) ? $_GET["controller"] : "" ;
    $action = isset($_GET["action"]) ? $_GET["action"] : "" ;

    $router->route($controller, $action);

