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
        /**
         * Application services
         */
        \Meow\Database\DatabaseServiceProviderInterface::class => \Meow\Database\DatabaseServiceProvider::class,
        /**
         * Other services
         */
        \May\AttributesTest\Services\ExampleServiceInterface::class => \May\AttributesTest\Services\ExampleService::class
    ],

    /**
     * Database
     */
    'Database' => [
        'dsn' => 'sqlite:/app/app.sqlite',
        'user' => 'user',
        'password' => 'pass'
    ]
];
