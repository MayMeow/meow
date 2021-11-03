<?php

require '../vendor/autoload.php';
require '../config/paths.php';

$app = new \Meow\Application();

//echo phpinfo();

try {
    if (!isset($_SERVER['PATH_INFO'])) {
        $request_uri = '/';
    } else {
        $request_uri = $_SERVER['PATH_INFO'];
    }
    $result = $app->callController($request_uri);

    echo json_encode($result);
} catch (\May\AttributesTest\Exceptions\NotAllowedGroupException $exception) {
    var_dump($exception->getMessage());
}