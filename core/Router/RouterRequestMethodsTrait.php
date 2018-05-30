<?php

namespace LoanApi\Core\Router;

use LoanApi\Core\Router\Exceptions;

trait RouterRequestMethodsTrait
{
    public function get($uri, $action)
    {
        $this->addRoute(['GET'], $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->addRoute(['POST'], $uri, $action);
    }

    public function put($uri, $action)
    {
        $this->addRoute(['PUT'], $uri, $action);
    }

    public function patch($uri, $action)
    {
        $this->addRoute(['PATCH'], $uri, $action);
    }

    public function delete($uri, $action)
    {
        $this->addRoute(['DELETE'], $uri, $action);
    }

    public function options($uri, $action)
    {
        $this->addRoute(['OPTIONS'], $uri, $action);
    }
}
