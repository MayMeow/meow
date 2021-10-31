<?php

namespace May\AttributesTest;

use May\AttributesTest\Attributes\AllowToAttribute;
use May\AttributesTest\Attributes\NameAttribute;
use May\AttributesTest\Models\User;
use May\AttributesTest\Repositories\UsersRepository;
use May\AttributesTest\Services\ExampleServiceInterface;
use Meow\Attributes\DefaultRoute;
use Meow\Attributes\Route;
use Meow\Controllers\AppController;

#[Route('/main')]
class MainController extends AppController
{
    protected UsersRepository $repository;

    protected ExampleServiceInterface $exampleService;

    public function __construct(UsersRepository $repository, ExampleServiceInterface $exampleService)
    {
        $this->repository = $repository;
        $this->exampleService = $exampleService;
    }

    #[NameAttribute("Emma")]
    #[AllowToAttribute('administrators')]
    #[AllowToAttribute('users')]
    #[Route('/hello')]
    #[DefaultRoute]
    public function sayHello(int $id) : string
    {
        $user = $this->repository->getUser($id)->getName();
        return "Hello $user";
    }

    #[Route("/good-bye")]
    public function sayGoodBye() : string
    {
        return 'GoodBye';
    }
}