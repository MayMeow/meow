<?php

namespace May\AttributesTest\Repositories;

use May\AttributesTest\Models\User;

class UsersRepository
{
    public function getUser(string $name) : User
    {
        $user = new User();
        $user->setName($name);

        return $user;
    }
}