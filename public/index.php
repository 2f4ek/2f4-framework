<?php

use Framework2f4\Controller\ExampleController;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Log\LoggerInterface;

require __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/service_container.php';
$request = ServerRequest::fromGlobals();

$routes = [
    '/' => [
        'GET' => [ExampleController::class, 'testGet'],
        'POST' => [ExampleController::class, 'testPost'],
        'PUT' => [ExampleController::class, 'testPut'],
    ],
];

$uri = $request->getUri()->getPath();
$method = $request->getMethod();
$controllerInfo = $routes[$uri][$method] ?? null;
if ($controllerInfo) {
    [$controller, $method] = $controllerInfo;
    $controller = new $controller($container->get(LoggerInterface::class));
    $response = $controller->$method($request);

    echo $response->getBody();
} else {
    echo "404 Not Found";
}