<?php

namespace Meow\DI;

interface ContainerInterface
{
    public function resolve(?string $object = null, array $parameters = []) : object;
}