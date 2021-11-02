<?php

namespace Meow;

use Meow\Attributes\DefaultRoute;
use Meow\Attributes\Route;
use Meow\Attributes\Router;
use Meow\Container\ApplicationContainer;
use Meow\Controllers\AppController;
use Meow\Tools\Configuration;

class Application extends ApplicationContainer
{
    protected array $applicationConfig;

    /** @var array<Route>|array $routes */
    protected array $routes;

    public function __construct()
    {
        $this->configure();
        $this->registerServices();

        try {
            $this->registerRoutes();
        } catch (\ReflectionException $e) {
        }
    }

    /**
     * Read Application configuration file
     */
    protected function configure()
    {
        // $this->applicationConfig = include(CONFIG . 'application.php');
    }

    /**
     * Register Routes from registered controllers from application config file
     * Use attributes to define routes
     *
     * @see Route::getRouteName()
     * @see DefaultRoute
     * @throws \ReflectionException
     */
    protected function registerRoutes() : void
    {
        $routes = [];

        $controllers = Configuration::read('Controllers');

        foreach ($controllers as $controller) {
            // check if class can be instantiated
            $reflectionClass = new \ReflectionClass($controller);
            if (!$reflectionClass->isInstantiable()) {
                continue;
            }

            // create new instance and resolve dependencies
            $instancedController = $this->resolve($controller);
            $reflectionClass = new \ReflectionClass($instancedController);

            // get controller route
            // Controller route must be set
            $controllerRouteAttribute = $reflectionClass->getAttributes(Route::class);
            if (!empty($controllerRouteAttribute)) {
                /** @var Route $controllerRoute */
                $controllerRoute = $controllerRouteAttribute[0]->newInstance();
                $controllerRouteName = $controllerRoute->getRouteName();

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

                        $routes[$controllerRouteName . $methodRouteName] = $methodRoute;
                    }

                    //Check for default route
                    $methodDefaultRouteAttribute = $method->getAttributes(DefaultRoute::class);
                    if (!empty($methodDefaultRouteAttribute)) {
                        $route = new Route('/');
                        $route->setMethod($method->getName());
                        $route->setController($controller);
                        $routes['/'] = $route;
                    }
                }
            }
        }

        $this->routes = $routes;
    }

    /**
     * Calling controller based on route
     *
     * @param string $routeName
     * @param array $request
     * @return string
     * @throws \ReflectionException
     */
    public function callController(string $routeName, array $request) : string
    {
        $router = new Router($this->routes);

        $calledRoute = $router->matchFromUri($routeName);
        $methodName = $calledRoute->getMethod();

        // Instead of calling new instance from reflection class call Container's resolve
        // This one will return new instance of controller but with resolved dependencies
        $controller = $this->resolve($calledRoute->getController());

        return $controller->$methodName($request['name']);
    }

    /**
     * Register application services from configuration file
     */
    protected function registerServices() : void
    {
        $services = Configuration::read('Services');

        foreach ($services as $k => $v)
        {
            $this->set($k, $v);
        }
    }
}