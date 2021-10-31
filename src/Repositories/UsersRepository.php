<?php

namespace May\AttributesTest\Repositories;

use May\AttributesTest\Models\User;
use Meow\Tools\DatabaseServiceProviderInterface;

class UsersRepository
{
    protected DatabaseServiceProviderInterface $databaseServiceProvider;

    public function __construct(DatabaseServiceProviderInterface $databaseServiceProvider)
    {
        $this->databaseServiceProvider = $databaseServiceProvider;
    }

    public function getUser(int $id) : User
    {
        $row = $this->databaseServiceProvider->getConnection()->fetch('SELECT * FROM Users WHERE id = ?', $id);

        $user = new User();
        $user->setName($row->name);

        return $user;
    }
}