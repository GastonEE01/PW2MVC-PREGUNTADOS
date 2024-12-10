<?php

class Router
{
    private $defaultController;
    private $defaultMethod;

    public function __construct($defaultController, $defaultMethod)
    {
        $this->defaultController = $defaultController;
        $this->defaultMethod = $defaultMethod;
    }

    public function route($controllerName, $methodName)
    {
        $controller = $this->getControllerFrom($controllerName);
        $this->executeMethodFromController($controller, $methodName);
    }

    private function getControllerFrom($module)
    {
        $controllerName = 'get' . ucfirst($module) . 'Controller';
        $validController = method_exists("Configuration", $controllerName) ? $controllerName : $this->defaultController;
        return call_user_func(array("Configuration", $validController));
    }

    private function executeMethodFromController($controller, $method)
    {
        $validMethod = method_exists($controller, $method) ? $method : $this->defaultMethod;

        // Si es un formulario POST, pasa los datos como argumento
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            call_user_func(array($controller, $validMethod), $_POST);
        } else {
            call_user_func(array($controller, $validMethod));
        }
    }

}