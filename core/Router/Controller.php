<?php

namespace LoanApi\Core\Router;

use LoanApi\Core\DependencyInjection\ContainerTrait;
use LoanApi\Core\DependencyInjection\Contracts\Locatable;
use LoanApi\Core\Router\Exceptions;

abstract class Controller implements Locatable
{
    use ContainerTrait;

    public function callAction($method, $parameters = [])
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    public function __call($method, $parameters)
    {
        throw new Exceptions\BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }
}
