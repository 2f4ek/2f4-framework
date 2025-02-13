<?php

use Dotenv\Dotenv;
use Framework2f4\Http\ServerRequest;
use Framework2f4\Http\Stream;
use Framework2f4\Http\Uri;
use Framework2f4\Route;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

$container = require __DIR__ . '/../config/service_container.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = new Uri($_SERVER['REQUEST_URI'] ?? '/');
$headers = \getallheaders();
$body = new Stream(fopen('php://input', 'r+'));
$request = new ServerRequest($method, $uri, $headers, $body, $_SERVER);
if ($request->getMethod() === 'POST' || $request->getMethod() === 'DELETE') {
    $request = $request->withParsedBody($_POST);
}
$router = $container->get(Route::class);

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