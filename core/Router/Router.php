<?php

namespace LoanApi\Core\Router;

use LoanApi\Core\DependencyInjection\LocatableService;
use LoanApi\Core\Http\Request;
use LoanApi\Core\Router\Exceptions;

class Router extends LocatableService
{
    use RouterRequestMethodsTrait;

    private $routes = [];
    private $prefix;

    public function __construct()
    {
        $routesFile = __ROUTES_DIR__ . '/api.php';
        if(!file_exists($routesFile)) {
            throw new Exception("File $routesFile not found.");
        }
        require_once $routesFile;

        return $this;
    }

    /**
     * Set router path prefix
     * @param string $prefix
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function addRoute(string $requestMethod, string $path, string $controller, string $controllerMethod)
    {
        $this->routes[] = new Route($requestMethod, $path, $controller, $controllerMethod);
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    // mach uri and load coresponding controller method
    // TODO: mach route with args
    public function dispatch(Request $request)
    {
        // if route found
        $route = array_filter($this->routes, function($route) use(&$request) {
            return $request->isPath($route->getPath()) && $request->isMethod($route->getRequestMethod());
        });

        if(!$route) {
            throw new Exceptions\HttpRouteNotFoundException('Route ' . $requestPath . ' is invalid.');
        }

        $route = array_pop($route);
        $controller = $route->getController();
        $controller = new $controller;
        // die(var_dump($controller));

        // TODO: parse wildcard parameters
        // inject some dependencies (instead of request, add auto from the config/container.php)
        $dependencies = [];
        call_user_func_array([$controller, $route->getControllerMethod()], $dependencies);
    }
}
