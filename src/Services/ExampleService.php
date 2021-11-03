<?php

namespace May\AttributesTest\Services;

class ExampleService implements ExampleServiceInterface
{

    public function getServicename(): string
    {
        return ExampleService::class;
    }
}