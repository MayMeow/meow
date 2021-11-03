<?php

namespace May\AttributesTest;

use May\AttributesTest\Attributes\AllowToAttribute;
use May\AttributesTest\Attributes\NameAttribute;
use May\AttributesTest\Models\User;
use May\AttributesTest\Repositories\UsersRepository;
use May\AttributesTest\Services\ExampleServiceInterface;
use Meow\Controllers\AppController;
use Meow\Routing\Attributes\DefaultRoute;
use Meow\Routing\Attributes\Prefix;
use Meow\Routing\Attributes\Route;

class MainController extends AppController
{
    protected UsersRepository $repository;

    protected ExampleServiceInterface $exampleService;

    public function __construct(UsersRepository $repository, ExampleServiceInterface $exampleService)
    {
        $this->repository = $repository;
        $this->exampleService = $exampleService;
    }

    #[Route('/')]
    public function index() : string
    {
        return 'Hello World!';
    }

    #[NameAttribute("Emma")]
    #[AllowToAttribute('administrators')]
    #[AllowToAttribute('users')]
    #[Route('/hello/{id}/{surname}')]
    public function sayHello() : string
    {
        $user = $this->repository->getUser($this->getRequest('id'))->getName();
        $surname = $this->getRequest('surname');
        return "Hello, $user, $surname";
    }

    #[Route("/good-bye")]
    public function sayGoodBye() : string
    {
        return 'GoodBye';
    }
}