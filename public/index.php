<?php

use Meow\Core\Application;
use Meow\Routing\Exceptions\NotFoundRouteException;

require '../vendor/autoload.php';
require '../config/paths.php';

$app = new Application();

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
    echo $exception->getMessage();
} catch (NotFoundRouteException $e2) {
    echo $e2->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}