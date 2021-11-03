# Routing

`\Meow\Routing` namespace

This is really simple PHP router which using PHP 8 attributes to define routes
to the methods in controllers.

## Create new Router

### Defining controllers

Router need to have statically defined controllers in array as example bellow

```php
/**
 * Register your application's controller here
*/
'Controllers' => [
    \May\AttributesTest\MainController::class,
    \May\AttributesTest\Controllers\ExampleController::class
],
```
place them somewhere in you application config

### Building router
```php
$controllers = Configuration::read('Controllers');
$router = new RoutingServiceProvider($controllers, $this);
```

Second parameter have to be `ContainerInterface`. Check Router provider constructor

```php
/**
 * @param array $controllers Array where are controllers defined
 * @param ContainerInterface $container Need container interface to resolve dependencies when building routes
 */
public function __construct(array $controllers, ContainerInterface $container)
{
    $this->controllers = $controllers;
    $this->container = $container;
}
```

## Using router

### Defining routes

To define route to the controller add attribute on the method with your requested path

```php
# Route without attributes
#[Route('/hello/{id}/{surname}')]
public function sayHello() : string

# Route with attributes
#[Route("/good-bye")]
public function sayGoodBye() : string

# Default route
#[Route('/')]
public function index() : string
```

**Known Limitations**: If you define same route on 2nd function, the latter will overwrite
firs one defined.

### Resloving routes

```php
$calledRoute = $this->router->matchFromUri($_SERVER['PATH_INFO']);
```

### Getting controller and method

```php
$calledRoute->getController();
$calledRoute->getMethod();
```

### Getting parameters

```php
if ($calledRoute->hasParameters()) {
    $request = $calledRoute->getParameters();
}
```

### Prefixes (Not implemented yet!)

To add prefix to your route use prefix attribute on controller class

```php
#[Prefix('/api')]
class ExampleController extends AppController
```