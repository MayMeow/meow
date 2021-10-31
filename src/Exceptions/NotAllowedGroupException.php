<?php

namespace May\AttributesTest\Exceptions;

use Throwable;

class NotAllowedGroupException extends \Exception
{
    public function __construct($message = "", $code = 3, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}