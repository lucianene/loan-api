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

    public function handle(Container $container)
    {
        $this->container = $container;
        $this->_loadRoutes();

        return $this;
    }

    private function _loadRoutes()
    {
        $routesFile = __ROUTES_DIR__ . '/api.php';
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

    private function _matchRoute(Request $request)
    {
        // check if route uri&method match
        $route = array_filter($this->routes, function ($route) use ($request) {
            if ($request->isUri($route->getUri()) && $route->hasMethod($request->getMethod())) {
                return $route;
            }
        });

        // check if there is a match
        if (!$route) {
            throw new Exceptions\HttpRouteNotFoundException('Route ' . $request->getUri() . ' is invalid.');
        }

        // remove the parent array and return the route
        return array_pop($route);
    }


    public function dispatch(Request $request)
    {
        $route = $this->_matchRoute($request);
        $route->run();
    }
}
