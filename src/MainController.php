<?php

namespace May\AttributesTest;

use May\AttributesTest\Attributes\AllowToAttribute;
use May\AttributesTest\Attributes\NameAttribute;
use May\AttributesTest\Models\User;
use Meow\Attributes\DefaultRoute;
use Meow\Attributes\Route;
use Meow\Controllers\AppController;

#[Route('/main')]
class MainController extends AppController
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    #[NameAttribute("Emma")]
    #[AllowToAttribute('administrators')]
    #[AllowToAttribute('users')]
    #[Route('/hello')]
    #[DefaultRoute]
    public function sayHello(string $name) : string
    {
        $namz = $this->user->getName($name);
        return "Hello $namz";
    }

    #[Route("/good-bye")]
    public function sayGoodBye() : string
    {
        return 'GoodBye';
    }
}