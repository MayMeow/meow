<?php

namespace Meow\Routing\Attributes;

/**
 * Add prefix into route
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class Prefix
{
    public string $prefixName;

    public function __construct(string $prefixName)
    {
        $this->prefixName = $prefixName;
    }

    /**
     * @return string
     */
    public function getPrefixName(): string
    {
        return $this->prefixName;
    }
}