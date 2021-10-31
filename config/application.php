<?php

return [
    /**
    * Register your application's controller here
    */
    'Controllers' => [
        \May\AttributesTest\MainController::class,
        \May\AttributesTest\Controllers\ExampleController::class
    ],

    /**
     * Application Services
     */
    'Services' =>
    [
        \May\AttributesTest\Services\ExampleServiceInterface::class => \May\AttributesTest\Services\ExampleService::class
    ]
];
