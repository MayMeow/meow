# core

__namespace:__ `meow\core`

Base for web applications. This is wrapper arround `meow\di` and `meow\router`. On top of it, it contains also functionality for reading configuration from arrays

[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/D1D5DMOTA)

## Installation

To instal this one use following command

```bash
composer require meow/di
```

## Creating new application

Create new application by creating new instance of `Meow\Core\Application`

```php
require '../config/paths.php';

$app = new \Meow\Core\Application();
```

By default application will look for configuration and register new routes and services from `application.php` file in `CONFIG`  folder. Here is example of that config file:

```php
return [
    /**
    * Register your application's controller here, this are used for configuring routes
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
        \Meow\AttributesTest\Database\DatabaseServiceProviderInterface::class => \Meow\AttributesTest\Database\DatabaseServiceProvider::class,
    ],

    //... more configuration
];
```

## Getting result from controller

This is what you congroller returns. To get the controller from uri you can do this:

```php
    if (!isset($_SERVER['PATH_INFO'])) {
        $request_uri = '/';
    } else {
        $request_uri = $_SERVER['PATH_INFO'];
    }
    $result = $app->callController($request_uri); // controllers should return string
```

__License: MIT__