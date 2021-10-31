<?php

namespace May\AttributesTest\Models;

class User
{
    public function getName(string $name) : string
    {
        return "Meow $name";
    }
}