<?php
declare(strict_types=1);

namespace Meow\Core;

use Meow\Controllers\AppController;
use Meow\DI\ApplicationContainer;
use Meow\Core\Tools\Configuration;
use Meow\DI\ContainerInterface;
use Meow\Routing\Router;

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
        $this->router = Router::getRouter($controllers);
    }

    /**
     * Calling controller based on route
     *
     * @param string $routeName use server PATH_INFO variable on input
     * @return string
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function callController(string $routeName) : string
    {
        // get route from router
        $calledRoute = $this->router->matchFromUrl($routeName);
        // get action method from route
        $methodName = $calledRoute->getAction();

        // Resolve controller from DI container -> it rerutns inscance of controller
        // and injects all dependencies
        /** @var AppController $controller */
        $controller = $this->resolve($calledRoute->getController());

        // check if there are parameters
        // if route contains parameters they must be provided in url
        if ($calledRoute->hasParameters()) {
            $request = $calledRoute->getParameters();

            // pass requested parameters from router to the controller (called route)
            $controller->setRequest($request);

            return $controller->$methodName();
        }

        return $controller->$methodName();
    }

    /**
     * Register application services from configuration file
     * Services are defined with Interfaces and must be added to service before you trying resolve them
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