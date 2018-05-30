<?php

namespace LoanApi\Core\DependencyInjection;

use LoanApi\Core\DependencyInjection\Container;

trait ContainerTrait
{
    protected $container = null;

    public function setContainer(Container $container) {
        $this->container = $container;
        return $this;
    }

    public function getContainer() {
        return $this->container;
    }
}
