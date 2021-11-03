<?php

namespace Meow\Routing\Attributes;

#[\Attribute]
class DefaultRoute extends Route
{
    /**
     * @param string|null $routeName
     */
    public function __construct(?string $routeName = '/')
    {
        parent::__construct($routeName);
    }
}