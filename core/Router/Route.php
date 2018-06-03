<?php

namespace LoanApi\Core\Router;

use LoanApi\Core\DependencyInjection\ContainerTrait;
use LoanApi\Core\DependencyInjection\Contracts\Locatable;
use LoanApi\Core\Router\Router;
use ReflectionClass;

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

    public function getUriWildcards()
    {
        preg_match("{([^\}]*)}", $this->uri, $matches,PREG_OFFSET_CAPTURE);
        die(var_dump($matches));
    }

    public function getAction()
    {
        return $this->action;
    }

    public function isControllerAction()
    {
        return is_string($this->action);
    }

    public function getControllerClassString()
    {
        return explode('@', $this->action)[0];
    }

    public function getControllerMethod()
    {
        return explode('@', $this->action)[1];
    }

    public function runController()
    {
        $classString = $this->getControllerClassString();
        $controllerInstance = $this->container->reflectControllerDependencies($classString);
        $controllerInstance->setContainer($this->container)->{$this->getControllerMethod()}();
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
