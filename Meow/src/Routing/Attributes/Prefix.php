<?php

namespace Meow\Routing\Attributes;

use Meow\Tools\Text;

/**
 * Add prefix into route
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class Prefix
{
    public string $prefixName;

    public function __construct(string $prefixName)
    {
        $text = new Text();

        if (!$text->startWith($prefixName, '\/') || $text->endsWith($prefixName, '\/')) {
            throw new \Exception('Prefix name must start with slash and must not end with slash');
        }

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