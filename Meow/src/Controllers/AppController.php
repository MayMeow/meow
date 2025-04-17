<?php

namespace Meow\Core\Controllers;

class AppController
{
    protected array $request;

    /**
     * @param string $key
     * @return string
     */
    public function getRequest(string $key): string
    {
        return $this->request[$key];
    }

    /**
     * @param array $request
     */
    public function setRequest(array $request): void
    {
        $this->request = $request;
    }

}