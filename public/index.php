<?php

use Framework2f4\Controller\ExampleController;
use Framework2f4\Http\ServerRequest;
use Framework2f4\Http\Stream;
use Framework2f4\Http\Uri;
use Framework2f4\Route;

require __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/service_container.php';

$routes = [
    '/' => [
        'GET' => [ExampleController::class, 'testGet'],
        'POST' => [ExampleController::class, 'testPost'],
        'PUT' => [ExampleController::class, 'testPut'],
    ],
];

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = new Uri($_SERVER['REQUEST_URI'] ?? '/');
$headers = getallheaders();
$body = new Stream(fopen('php://input', 'r+'));
$request = new ServerRequest($method, $uri, $headers, $body, $_SERVER);

$router = new Route($container, $routes);
$response = $router->dispatch($request);

header(sprintf(
    'HTTP/%s %s %s',
    $response->getProtocolVersion(),
    $response->getStatusCode(),
    $response->getReasonPhrase()
));

foreach ($response->getHeaders() as $header => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $header, $value), false);
    }
}

echo $response->getBody();