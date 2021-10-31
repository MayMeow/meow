<?php

namespace May\AttributesTest\Controllers;

use May\AttributesTest\Attributes\AllowToAttribute;
use Meow\Attributes\Route;
use Meow\Controllers\AppController;

#[Route('/example')]
class ExampleController extends AppController
{
    #[Route('/index')]
    #[AllowToAttribute('Administrators')]
    public function index()
    {
        $className = ExampleController::class;

        return "This is index() from $className";
    }
}