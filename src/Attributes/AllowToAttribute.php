<?php

namespace May\AttributesTest\Attributes;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class AllowToAttribute
{
    protected string $securityGroup;

    public function __construct(string $securityGroup)
    {
        $this->securityGroup = $securityGroup;
    }

    /**
     * @return string
     */
    public function getSecurityGroup(): string
    {
        return $this->securityGroup;
    }
}