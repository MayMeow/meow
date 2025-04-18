<?php

namespace May\AttributesTest\Database;

use Nette\Database\Connection;

interface DatabaseServiceProviderInterface
{
    /**
     * Undocumented function
     *
     * @return Connection
     */
    public function getConnection() : Connection;
}