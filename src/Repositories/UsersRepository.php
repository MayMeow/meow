<?php

namespace May\AttributesTest\Repositories;

use May\AttributesTest\Database\DatabaseServiceProviderInterface;
use May\AttributesTest\Models\User;

class UsersRepository
{
    protected DatabaseServiceProviderInterface $databaseServiceProvider;

    /**
     * UsersRepository constructor
     *
     * @param DatabaseServiceProviderInterface $databaseServiceProvider
     */
    public function __construct(DatabaseServiceProviderInterface $databaseServiceProvider)
    {
        $this->databaseServiceProvider = $databaseServiceProvider;
    }

    /**
     * getUser function
     *
     * @param integer $id
     * @return User
     */
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