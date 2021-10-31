<?php

namespace May\AttributesTest;

use May\AttributesTest\Attributes\AllowToAttribute;
use May\AttributesTest\Attributes\NameAttribute;
use Meow\Attributes\DefaultRoute;
use Meow\Attributes\Route;
use Meow\Controllers\AppController;

#[Route('/main')]
class MainController extends AppController
{
    #[NameAttribute("Emma")]
    #[AllowToAttribute('administrators')]
    #[AllowToAttribute('users')]
    #[Route('/hello')]
    #[DefaultRoute]
    public function sayHello(string $name) : string
    {
        return "Hello $name";
    }

    #[Route("/good-bye")]
    public function sayGoodBye() : string
    {
        return 'GoodBye';
    }
}