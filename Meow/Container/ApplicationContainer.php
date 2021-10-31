<?php

namespace Meow\Container;

class ApplicationContainer
{
    /**
     * @var array
     */
    protected array $instances = [];

    /**
     * Add service to container
     *
     * @param string $interface
     * @param string|null $object
     */
    public function set(string $interface, ?string $object = null) : void
    {
        if ($object == null) {
            $object = $interface;
        }

        $this->instances[$interface] = $object;
    }

    /**
     * Get Service from container
     *
     * @param string $interface
     * @param array $parameters
     * @return mixed|object
     * @throws \Exception
     */
    public function get(string $interface, array $parameters = []) : object
    {
        if (!isset($this->instances[$interface])) {
            $this->set($interface);
        }

        return $this->resolve($this->instances[$interface], $parameters);
    }

    /**
     * @param string|null $object
     * @param array $parameters
     * @return object
     * @throws \ReflectionException
     */
    public function resolve(?string $object = null, array $parameters =[]) : object
    {
        if ($object instanceof \Closure) {
            return $object($this, $parameters);
        }

        $reflector = new \ReflectionClass($object);

        if (!$reflector->isInstantiable()) {
            throw new \Exception("Class {$object} is not instantiable");
        }

        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return $reflector->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * Resolve dependencies
     *
     * @param \ReflectionParameter[]|array $parameters
     * @return array
     * @throws \Exception
     */
    public function getDependencies(array $parameters) : array
    {
        $dependencies = [];

        foreach ($parameters as $parameter){
            //$dependency = $parameter->getClass();
            $dependency = $parameter->getType() && !$parameter->getType()->isBuiltin()
                ? new \ReflectionClass($parameter->getType()->getName())
                : null;
            if($dependency == null) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new \Exception("Can not resolve class dependency {$parameter->name}");
                }
            } else {
                $dependencies[] = $this->get($dependency->name);
            }
        }

        return $dependencies;
    }
}