<?php

namespace Meow;

use Meow\Attributes\DefaultRoute;
use Meow\Attributes\Route;
use Meow\Controllers\AppController;

class Application
{
    protected array $applicationConfig;

    protected array $routes;

    public function __construct()
    {
        $this->configure();

        try {
            $this->registerRoutes();
        } catch (\ReflectionException $e) {
        }

        var_dump($this->routes);
    }

    protected function configure()
    {
        $this->applicationConfig = include (CONFIG . 'controllers.php');
    }

    /**
     * @throws \ReflectionException
     */
    protected function registerRoutes() : void
    {
        $routes = [];

        $controllers = $this->applicationConfig['Controllers'];

        foreach ($controllers as $controller) {
            $reflectionClass = new \ReflectionClass($controller);

            if (!$reflectionClass->isInstantiable()) {
                continue;
            }

            $reflectionClass->newInstance();

            //get controller route
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

                        $routes[$controllerRouteName . $methodRouteName] = [
                            'Controller' => $controller,
                            'Method' => $method->getName()
                        ];
                    }

                    //Check for default route
                    $methodDefaultRouteAttribute = $method->getAttributes(DefaultRoute::class);
                    if (!empty($methodDefaultRouteAttribute)) {
                        $routes['/'] = [
                            'Controller' => $controller,
                            'Method' => $method->getName()
                        ];
                    }
                }
            }
        }

        $this->routes = $routes;
    }

    public function callController(string $routeName, array $request) : string
    {
        $calledRoute = $this->routes[$routeName];

        $controller = new $calledRoute['Controller'];
        $methodName = $calledRoute['Method'];

        $reflactionClass = new \ReflectionClass($controller);

        return $controller->$methodName($request['name']);
    }
}