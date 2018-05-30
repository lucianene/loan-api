<?php

namespace LoanApi\Core\DependencyInjection\Contracts;

use LoanApi\Core\DependencyInjection\Container;

interface Locatable
{
    public function getContainer();
    public function setContainer(Container $container);
}
