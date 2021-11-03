<?php

namespace Meow\Routing\Attributes;

#[\Attribute]
class Route
{
    /** @var string Name of route */
    protected string $routeName;

    /** @var string $controller Name of controller */
    protected string $controller;

    /** @var string $method Name of called method */
    protected string $method;

    /** @var array<string> $parameters */
    protected array $parameters;

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

    public function match(string $routeName)
    {
        $regex = $this->getRouteName();
        foreach ($this->getParametersNames() as $routeParam) {
            $routeParamName = trim($routeParam, '{\}');
            $regex = str_replace($routeParam, '(?P<' . $routeParamName . '>[^/]++)', $regex);
        }

        if (preg_match('#^' . $regex . '$#sD', self::trimPath($routeName), $matches)) {
            $values = array_filter($matches, static function($key) {
                return is_string($key);
            }, ARRAY_FILTER_USE_KEY);

            foreach ($values as $key => $value) {
                $this->parameters[$key] = $value;
            }

            return true;
        }
        return false;
    }

    /**
     * @return array<string>
     */
    public function getParametersNames() : array
    {
        preg_match_all('/{[^}]*}/', $this->getRouteName(), $matches);
        return reset($matches) ?? [];
    }

    public function hasParameters() : bool
    {
        return $this->getParametersNames() !== [];
    }

    public static function trimPath(string $path) : string
    {
        return '/' . rtrim(ltrim(trim($path), '/'), '/');
    }
}
