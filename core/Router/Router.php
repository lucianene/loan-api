<?php

namespace LoanApi\Core\Router;

use LoanApi\Core\DependencyInjection\Container;
use LoanApi\Core\DependencyInjection\ContainerTrait;
use LoanApi\Core\DependencyInjection\Contracts\Locatable;
use LoanApi\Core\Http\Request;
use LoanApi\Core\Router\Exceptions;

class Router implements Locatable
{
    use ContainerTrait, RouterRequestMethodsTrait;

    private $routes = [];
    private $prefix = '';
    private $request = null;

    public function __construct(Container $container, Request $request)
    {
        $this->container = $container;
        $this->request = $request;

        // load routes
        $routesFile = routes_dir('/api.php');
        if(!file_exists($routesFile)) {
            throw new Exception("File $routesFile not found.");
        }
        require_once $routesFile;
    }

    /**
     * Set router uri prefix
     * @param string $prefix
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Add route to the collection
     * @param array $methods
     * @param string $uri
     * @param mixed $action
     * @return void
     */
    protected function addRoute($methods, $uri, $action)
    {
        $this->routes[] = $this->createRoute($methods, $uri, $action);
    }

    /**
     * Create route instance
     *
     * @param  array $methods
     * @param  array $uri
     * @param  mixed $action
     * @return Route
     */
    private function createRoute($methods, $uri, $action)
    {
        if(!is_callable($action) && !is_string($action) || !is_callable($action) && strpos($action, '@') === false) {
            throw new Exceptions\InvalidRouteFormatException;
        }

        return (new Route($methods, $this->prefix . $uri, $action))
                ->setContainer($this->container)
                ->setRouter($this);
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * TODO: match wildcards
     *
     * @param  Request $request
     * @return Route
     */
    public function matchRoute(Request $request)
    {
        // match route
        foreach($this->routes as $route)
        {
            if($request->isUri($route->getUri()) && $route->hasMethod($request->getMethod())) {
                break;
            }
            $route = null;
        }

        if (!$route) {
            throw new Exceptions\HttpRouteNotFoundException('Route ' . $request->getUri() . ' is invalid.');
        }

        return $route;
    }

    public function dispatch()
    {
        $route = $this->matchRoute($this->request);
        $route->run();
    }
}
