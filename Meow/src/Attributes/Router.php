<?php

namespace Meow\Attributes;

class Router
{
    /** @var array<Route> $routes */
    protected array $routes;

    /**
     * @param array<Route> $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
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