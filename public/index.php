<?php

use Framework2f4\Http\ServerRequest;
use Framework2f4\Http\Stream;
use Framework2f4\Http\Uri;
use Framework2f4\Middleware\AuthMiddleware;
use Framework2f4\Route;

require __DIR__ . '/../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$container = require __DIR__ . '/../config/service_container.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = new Uri($_SERVER['REQUEST_URI'] ?? '/');
$headers = \getallheaders();
$body = new Stream(fopen('php://input', 'r+'));
$request = new ServerRequest($method, $uri, $headers, $body, $_SERVER);

$router = $container->get(Route::class);
$router->addMiddleware(new AuthMiddleware());

$response = $router->dispatch($request);

\header(sprintf(
    'HTTP/%s %s %s',
    $response->getProtocolVersion(),
    $response->getStatusCode(),
    $response->getReasonPhrase()
));

foreach ($response->getHeaders() as $header => $values) {
    foreach ($values as $value) {
        \header(sprintf('%s: %s', $header, $value), false);
    }
}

echo $response->getBody();