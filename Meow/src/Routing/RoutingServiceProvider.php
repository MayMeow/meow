<?php

namespace Meow\Core\Routing;

use Meow\DI\ContainerInterfac;
use Meow\DI\ContainerInterface;
use Meow\Routing\Attributes\DefaultRoute;
use Meow\Routing\Attributes\Prefix;
use Meow\Routing\Attributes\Route;
use Meow\Routing\Router;

/**
 * This class s here to provide new router from defined routes
 */
class RoutingServiceProvider
{
    protected array $controllers;

    protected ContainerInterface $container;

    /**
     * @param array $controllers Array where are controllers defined
     * @param ContainerInterface $container Need container interface to resolve dependencies when building routes
     */
    public function __construct(array $controllers, ContainerInterface $container)
    {
        $this->controllers = $controllers;
        $this->container = $container;
    }

    /**
     * Build router from all defined routes and return it to application
     *
     * @return Router
     * @throws \ReflectionException
     */
    public function getRouter() : Router
    {
        return Router::getRouter($this->controllers);
    }
}