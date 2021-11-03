<?php

namespace Meow\Database;

use Nette\Database\Connection;

interface DatabaseServiceProviderInterface
{
    public function getConnection() : Connection;
}