<?php

namespace Meow\Tools;

use Nette\Database\Connection;

interface DatabaseServiceProviderInterface
{
    public function getConnection() : Connection;
}