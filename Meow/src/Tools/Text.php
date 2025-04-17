<?php

namespace Meow\Core\Tools;

class Text
{
    /**
     * Check if first character of string is provided character
     *
     * @param string $text
     * @param string $char
     * @return bool
     */
    public function startWith(string $text, string $char) : bool
    {
        return (bool)preg_match('/^' . $char . '/', $text);
    }

    /**
     * Check if string ends with provided character.
     *
     * @param string $text
     * @param string $char
     * @return bool
     */
    public function endsWith(string $text, string $char) : bool
    {
        return preg_match('/' . $char . '{1}$/', $text) && strlen($text) > 1;
    }
}