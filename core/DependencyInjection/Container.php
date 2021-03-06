<?php

namespace LoanApi\Core\DependencyInjection;

use LoanApi\Core\DependencyInjection\Contracts\Locatable;
use LoanApi\Core\DependencyInjection\Exceptions;
use ReflectionClass;

class Container
{
    private $registry = [];
    private $instances = [];
    private $configServices = [];

    public function __construct($configServices)
    {
        $this->configServices = load_file_as_array($configServices);

        // register services without custom parameters
        foreach ($this->configServices as $key => $class) {
            $this->register($key, $class);
        }

        // save the container instance
        $this->instances['container'] = $this;
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

        // if the service already resolved return the instance
        if (!$newInstance && array_key_exists($key, $this->instances)) {
            return $this->instances[$key];
        }

        // reflect controller dependencies and get the instance
        $service = $this->reflectControllerDependencies($this->registry[$key]);

        // ensure that the service has the Locatable contract
        if (!$service instanceof Locatable) {
            throw new Exceptions\ServiceNotLocatable('Please implement the Locatable interface on the service.');
        }

        // attach the container to the service
        $service->setContainer($this);

        // add the service into the instances bag and return
        return $this->instances[$key] = $service;
    }

    /**
     * @param  string $classString
     * @return Locatable
     */
    public function reflectControllerDependencies($classString)
    {
        $reflectionClass = new ReflectionClass($classString);

        // check if the constructor exist
        if(!$classConstructor = $reflectionClass->getConstructor()) {
            return new $classString;
        }

        // collect instance variables for the constructor
        $parameters = [];
        foreach($classConstructor->getParameters() as $classParameter)
        {
            if($serviceKey = array_search(
                $classParameter->getClass()->getName(), $this->configServices
            )) {
                $parameters[] = $this->get($serviceKey);
            }
        }

        // create the instance
        return new $classString(...$parameters);
    }

    /**
     * @return array Binding instances
     */
    public function getInstances()
    {
        return $this->instances;
    }
}
