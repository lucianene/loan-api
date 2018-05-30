<?php

namespace LoanApi\Core\Router;

class Route
{
    private $requestMethod;
    private $path;
    private $controller;
    private $controllerMethod;

    public function __construct($requestMethod, $path, $controller, $controllerMethod)
    {
        $this->requestMethod = $requestMethod;
        $this->path = $path;
        $this->controller = $controller;
        $this->controllerMethod = $controllerMethod;
    }

    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getControllerMethod()
    {
        return $this->controllerMethod;
    }

    public function getControllerAndMethod()
    {
        return $this->controller . '@' . $this->controllerMethod;
    }
}
