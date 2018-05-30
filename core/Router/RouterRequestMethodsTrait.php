<?php

namespace LoanApi\Core\Router;

use LoanApi\Core\Router\Exceptions;

trait RouterRequestMethodsTrait
{
    public function get($route, $controllerAndMethod)
    {
        $this->register('GET', $route, $controllerAndMethod);
    }

    public function post($route, $controllerAndMethod)
    {
        $this->register('POST', $route, $controllerAndMethod);
    }

    public function put($route, $controllerAndMethod)
    {
        $this->register('PUT', $route, $controllerAndMethod);
    }

    public function patch($route, $controllerAndMethod)
    {
        $this->register('PATCH', $route, $controllerAndMethod);
    }

    public function delete($route, $controllerAndMethod)
    {
        $this->register('DELETE', $route, $controllerAndMethod);
    }

    public function options($route, $controllerAndMethod)
    {
        $this->register('OPTIONS', $route, $controllerAndMethod);
    }

    private function register($requestMethod, $route, $controllerAndMethod)
    {
        $controllerAndMethod = explode('@', $controllerAndMethod);

        if(count($controllerAndMethod) < 2) {
            throw new Exceptions\InvalidRouteFormatException;
        }

        $path = trim($route, '/');
        if($this->prefix) {
            $path = trim($this->prefix . '/' . $path, '/');
        }

        $this->addRoute($requestMethod, $path, $controllerAndMethod[0], $controllerAndMethod[1]);
    }
}
