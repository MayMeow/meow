<?php
declare(strict_types=1);

namespace Meow;

use Meow\Controllers\AppController;
use Meow\DI\ApplicationContainer;
use Meow\DI\ContainerInterface;
use Meow\Routing\Attributes\DefaultRoute;
use Meow\Routing\Attributes\Route;
use Meow\Routing\Router;
use Meow\Routing\RoutingServiceProvider;
use Meow\Tools\Configuration;

class Application extends ApplicationContainer implements ContainerInterface
{
    protected array $applicationConfig;

    /** @var Router $router */
    protected Router $router;

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
        $controllers = Configuration::read('Controllers');
        $router = new RoutingServiceProvider($controllers, $this);

        $this->router = $router->getRouter();

    }

    /**
     * Calling controller based on route
     *
     * @param string $routeName
     * @return string
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function callController(string $routeName) : string
    {
        $calledRoute = $this->router->matchFromUri($routeName);
        $methodName = $calledRoute->getMethod();

        // Instead of calling new instance from reflection class call Container's resolve
        // This one will return new instance of controller but with resolved dependencies
        /** @var AppController $controller */
        $controller = $this->resolve($calledRoute->getController());

        if ($calledRoute->hasParameters()) {
            $request = $calledRoute->getParameters();
            // pass parameters from router to the controller
            $controller->setRequest($request);
            return $controller->$methodName();
        }

        return $controller->$methodName();
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