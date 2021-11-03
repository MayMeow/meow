<?php

namespace May\AttributesTest\Repositories;

use May\AttributesTest\Models\User;
use Meow\Database\DatabaseServiceProviderInterface;

class UsersRepository
{
    protected DatabaseServiceProviderInterface $databaseServiceProvider;

    public function __construct(DatabaseServiceProviderInterface $databaseServiceProvider)
    {
        $this->databaseServiceProvider = $databaseServiceProvider;
    }

    public function getUser(int $id) : User
    {
        $user = new User();

        $row = $this->databaseServiceProvider->getConnection()->fetch('SELECT * FROM Users WHERE id = ?', $id);

        if (is_null($row)){
            throw new \Exception('User not found');
        }

        $user->setName($row->name);
        return $user;
    }
}