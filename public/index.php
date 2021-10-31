<?php

require '../vendor/autoload.php';
require '../config/app.php';

$app = new \Meow\Application();

//echo phpinfo();

try {
    if (!isset($_SERVER['PATH_INFO'])) {
        $request_uri = '/';
    } else {
        $request_uri = $_SERVER['PATH_INFO'];
    }
    $result = $app->callController($request_uri, [
        'name' => 'May'
    ]);

    var_dump($result);
} catch (\May\AttributesTest\Exceptions\NotAllowedGroupException $exception) {
    var_dump($exception->getMessage());
}