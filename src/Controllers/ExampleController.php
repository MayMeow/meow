<?php

namespace May\AttributesTest\Controllers;

use May\AttributesTest\Attributes\AllowToAttribute;
use May\AttributesTest\Services\ExampleServiceInterface;
use Meow\Controllers\AppController;
use Meow\Routing\Attributes\DefaultRoute;
use Meow\Routing\Attributes\Prefix;
use Meow\Routing\Attributes\Route;

#[Prefix('/api')]
class ExampleController extends AppController
{
    protected ExampleServiceInterface $exampleService;

    public function __construct(ExampleServiceInterface $exampleService)
    {
        $this->exampleService = $exampleService;
    }

    #[Route('/example')]
    #[AllowToAttribute('Administrators')]
    public function index()
    {
        $className = ExampleController::class;

        return "This is index() from $className";
    }

    #[Route('/example/example-service')]
    public function getServiceName()
    {
        return $this->exampleService->getServicename();
    }
}