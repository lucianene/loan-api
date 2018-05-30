<?php

namespace LoanApi\Core\Router;

use LoanApi\Core\DependencyInjection\ContainerTrait;
use LoanApi\Core\DependencyInjection\Contracts\Locatable;
use LoanApi\Core\Router\Router;

class Route implements Locatable
{
    use ContainerTrait;

    public $methods = [];
    public $uri;
    public $action;

    protected $router;

    public function __construct(array $methods, $uri, $action)
    {
        $this->methods = $methods;
        $this->uri = $uri;
        $this->action = $action;
    }

    public function setRouter(Router $router)
    {
        $this->router = $router;
        return $this;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function hasMethod($method)
    {
        return in_array($method, $this->methods);
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getControllerActionString()
    {
        return $this->controller . '@' . $this->action;
    }

    public function isControllerAction()
    {
        return is_string($this->action);
    }

    public function getController()
    {
        $controller = explode('@', $this->action)[0];
        return new $controller;
    }

    public function getControllerMethod()
    {
        return explode('@', $this->action)[1];
    }

    public function runController()
    {
        $this->getController()
            ->setContainer($this->container)
            ->callAction($this->getControllerMethod(), []);
    }

    public function runCallable()
    {
        call_user_func($this->getAction());
    }

    public function run()
    {
        if($this->isControllerAction()) {
            $this->runController();
        } else {
            $this->runCallable();
        }
    }
}
