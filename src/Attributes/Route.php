<?php

namespace May\AttributesTest\Attributes;

#[\Attribute]
class Route
{
    protected string $routeName;

    public function __construct(string $routeName)
    {
        $this->routeName = $routeName;
    }

    /**
     * @return string
     */
    public function getRouteName(): string
    {
        return $this->routeName;
    }
}
