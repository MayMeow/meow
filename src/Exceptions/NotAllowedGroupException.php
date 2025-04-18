<?php

namespace May\AttributesTest\Exceptions;

use Throwable;

class NotAllowedGroupException extends \Exception
{
    /**
     * Undocumented function
     *
     * @param string $message
     * @param integer $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 3, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}