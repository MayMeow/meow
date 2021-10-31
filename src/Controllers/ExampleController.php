<?php

namespace May\AttributesTest\Controllers;

use May\AttributesTest\AppController;
use May\AttributesTest\Attributes\AllowToAttribute;
use May\AttributesTest\Attributes\Route;

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