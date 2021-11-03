<?php

namespace May\AttributesTest;

use May\AttributesTest\Attributes\AllowToAttribute;
use May\AttributesTest\Attributes\NameAttribute;
use May\AttributesTest\Models\User;
use May\AttributesTest\Repositories\UsersRepository;
use May\AttributesTest\Services\ExampleServiceInterface;
use Meow\Controllers\AppController;
use Meow\Routing\Attributes\DefaultRoute;
use Meow\Routing\Attributes\Route;

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
    #[Route('/hello/{name}')]
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