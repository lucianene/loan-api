<?php

namespace LoanApi\Core\DependencyInjection;

use LoanApi\Core\DependencyInjection\Container;

abstract class LocatableService
{
    private $_container = null;

    public function setContainer(Container $container) {
        $this->_container = $container;
    }

    public function getContainer() {
        return $this->_container;
    }
}
