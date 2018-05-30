<?php

namespace LoanApi\Core\DependencyInjection;

use LoanApi\Core\DependencyInjection\Contracts\Locatable;
use LoanApi\Core\DependencyInjection\Exceptions;

class Container
{
    /**
     * Dependency registry
     * @var array
     */
    protected $registry = [];
    protected $instances = [];

    public function __construct($file)
    {
        if(!file_exists($file)) {
            throw new Exception("File $file not found.");
        }
        $services = include_once($file);
        foreach ($services as $key => $class) {
            $this->register($key, $class);
        }
    }

    /**
     * Bind container dependency manualy
     * @param  string $key   Dependency key
     * @param  mixed  $value Dependency class
     * @return mixed
     */
    public function bind($key, $value)
    {
        return $this->register($key, $value);
    }

    /**
     * Register container dependency
     * @param  string $key   Dependency key
     * @param  mixed  $value Dependency class
     * @return mixed
     */
    protected function register($key, $value)
    {
        if (array_key_exists($key, $this->registry)) {
            throw new Exceptions\ServiceAlreadyRegistered($key);
        }
        $this->registry[$key] = $value;

        return $value;
    }

    /**
     * Get container item
     * @param  string  $key Dependency key
     * @param  boolean $newInstance Create another instance if you need
     * @return mixed
     */
    public function get($key, $newInstance = false)
    {
        if (!array_key_exists($key, $this->registry)) {
            throw new Exceptions\DependencyNotFoundException("No {$key} is bound in the container.");
        }

        if (!$newInstance && array_key_exists($key, $this->instances)) {
            return $this->instances[$key];
        }

        $service = new $this->registry[$key];

        if (!($service instanceof Locatable)) {
            throw new Exceptions\ServiceNotLocatable();
        }

        $service->setContainer($this);

        if (!$newInstance) {
            $this->instances[$key] = $service;
        }
        return $service;
    }
}
