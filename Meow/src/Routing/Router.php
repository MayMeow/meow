<?php

namespace Meow\Routing;

use Meow\Routing\Attributes\Route;

class Router
{
    /** @var array<Route> $routes */
    protected array $routes = [];

    public function addRoute(Route $route)
    {
        array_push($this->routes, $route);
    }

    /**
     * @param string $uri
     * @return Route
     * @throws \Exception
     */
    public function matchFromUri(string $uri) : Route
    {
        foreach ($this->routes as $route) {
            if ($route->match($uri) == false) {
                continue;
            }

            return $route;
        }

        throw new \Exception('Route not found');
    }
}