<?php

namespace Meow\Attributes;

#[\Attribute]
class Route
{
    /** @var string Name of route */
    protected string $routeName;

    /** @var string $controller Name of controller */
    protected string $controller;

    /** @var string $method Name of called method */
    protected string $method;

    /**
     * Route Constructor
     * 
     * @param string $routeName
     */
    public function __construct(string $routeName)
    {
        $this->routeName = $routeName;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getRouteName(): string
    {
        return $this->routeName;
    }
}
