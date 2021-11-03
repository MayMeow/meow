<?php

namespace May\AttributesTest\Controllers;

use May\AttributesTest\Attributes\AllowToAttribute;
use May\AttributesTest\Services\ExampleServiceInterface;
use Meow\Controllers\AppController;
use Meow\Routing\Attributes\Route;

#[Route('/example')]
class ExampleController extends AppController
{
    protected ExampleServiceInterface $exampleService;

    public function __construct(ExampleServiceInterface $exampleService)
    {
        $this->exampleService = $exampleService;
    }

    #[Route('/index')]
    #[AllowToAttribute('Administrators')]
    public function index()
    {
        $className = ExampleController::class;

        return "This is index() from $className";
    }

    #[Route('/example-service')]
    public function getServiceName()
    {
        return $this->exampleService->getServicename();
    }
}