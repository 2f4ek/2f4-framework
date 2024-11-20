<?php

use Framework2f4\Controller\TestController;
use GuzzleHttp\Psr7\ServerRequest;

require __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/service_container.php';
$request = ServerRequest::fromGlobals();

$routes = [
    '/' => [
        'GET' => [TestController::class, 'testGet'],
        'POST' => [TestController::class, 'testPost'],
        'PUT' => [TestController::class, 'testPut'],
    ],
];

$uri = $request->getUri()->getPath();
$method = $request->getMethod();
$controllerInfo = $routes[$uri][$method] ?? null;
if ($controllerInfo) {
    [$controller, $method] = $controllerInfo;
    $controller = new $controller();
    $response = $controller->$method($request);

    echo $response->getBody();
} else {
    echo "404 Not Found";
}