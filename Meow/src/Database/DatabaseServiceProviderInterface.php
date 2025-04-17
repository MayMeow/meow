<?php

namespace Meow\Core\Database;

use Nette\Database\Connection;

interface DatabaseServiceProviderInterface
{
    public function getConnection() : Connection;
}