<?php

namespace Meow\Routing\Attributes;

/**
 * @deprecated use Route('/') instead
 * @see Route
 */
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