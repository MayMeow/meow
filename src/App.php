<?php

namespace May\AttributesTest;

use May\AttributesTest\Attributes\AllowToAttribute;
use May\AttributesTest\Attributes\DefaultRoute;
use May\AttributesTest\Attributes\Route;
use May\AttributesTest\Exceptions\NotAllowedGroupException;

class App
{
    protected array $appConfig;

    protected array $routes;

    public function __construct()
    {
        $this->configure();

        $this->routes = $this->registerRoutes();

        //var_dump($this->routes);
    }

    /**
     * @param string $controllerName
     * @param string $routeName
     * @param string $securityGroup
     * @return string
     * @throws NotAllowedGroupException
     * @throws \ReflectionException
     */
    public function callController(string $routeName, string $securityGroup, array $args) : string
    {
        $calledRoute = $this->routes[$routeName];

        $controller = new $calledRoute['Controller'];
        $methodName = $calledRoute['Method'];

        $reflectionClass = new \ReflectionClass($controller);

        // get allowed security group from attribute
        $attributes = $reflectionClass->getMethod($methodName)->getAttributes(AllowToAttribute::class);

        // skip checking if it is empty
        if (!empty($attributes)) {
            $allowedGroup = $attributes[0]->newInstance()->getSecurityGroup();

            // throw exception if group is not allowed to call action
            if ($allowedGroup != $securityGroup) {
                throw new NotAllowedGroupException("$securityGroup is not allowed to run method $routeName");
            }
        }

        return $controller->$methodName($args['name']);
    }

    protected function configure() : void
    {
        $this->appConfig = include(CONFIG . 'controllers.php');
    }

    public function registerRoutes() : array
    {
        $controllers = $this->appConfig['Controllers'];
        $routes = [];

        foreach ($controllers as $controller) {

            $instancedController = new $controller;
            $reflectionClass = new \ReflectionClass($instancedController);

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

        return $routes;
    }
}