<?php

namespace Meow\Tools;

use Nette\Database\Connection;

class DatabaseServiceProvider implements DatabaseServiceProviderInterface
{
    /**
     * Returns database connection
     *
     * @return Connection
     */
    public function getConnection(): Connection
    {
        $databaseConfig = Configuration::read('Database');

        return new Connection($databaseConfig['dsn'], $databaseConfig['user'], $databaseConfig['password']);
    }
}