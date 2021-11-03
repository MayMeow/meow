<?php

namespace Meow\Routing;

use Meow\DI\ApplicationContainer;
use Meow\DI\ContainerInterface;
use Meow\Routing\Attributes\DefaultRoute;
use Meow\Routing\Attributes\Prefix;
use Meow\Routing\Attributes\Route;

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
        $router = new Router();

        foreach ($this->controllers as $controller) {
            $controllerPrefixName = null;

            // check if class can be instantiated
            $reflectionClass = new \ReflectionClass($controller);
            if (!$reflectionClass->isInstantiable()) {
                continue;
            }

            // create new instance and resolve dependencies
            $instancedController = $this->container->resolve($controller);
            $reflectionClass = new \ReflectionClass($instancedController);
            $controllerPrefixAttribute = $reflectionClass->getAttributes(Prefix::class);

            if (!empty($controllerPrefixAttribute)) {
                /** @var Prefix $controllerPrefix */
                $controllerPrefix = $controllerPrefixAttribute[0]->newInstance();
                $controllerPrefixName = $controllerPrefix->getPrefixName();
            }

            // get controller methods
            $methods = $reflectionClass->getMethods();
            foreach ($methods as $method) {
                $methodRouteAttribute = $method->getAttributes(Route::class);

                if (!empty($methodRouteAttribute)) {
                    /** @var Route $methodRoute */
                    $methodRoute = $methodRouteAttribute[0]->newInstance();
                    $methodRouteName = $methodRoute->getRouteName();

                    $methodRoute->setController($controller);
                    $methodRoute->setMethod($method->getName());

                    if (!is_null($controllerPrefixName)) {
                        $methodRoute->setRoutePrefix($controllerPrefixName);
                    }

                    $router->addRoute($methodRoute);
                }

                //Check for default route
                $methodDefaultRouteAttribute = $method->getAttributes(DefaultRoute::class);
                if (!empty($methodDefaultRouteAttribute)) {
                    $route = new Route('/');
                    $route->setMethod($method->getName());
                    $route->setController($controller);

                    $router->addRoute($route);
                }
            }

        }

        return $router;
    }
}