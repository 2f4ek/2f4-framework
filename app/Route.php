<?php

namespace Framework2f4;

use Psr\Http\Message\ServerRequestInterface as Request;
use Framework2f4\Http\Response;

readonly class Route
{
    public function __construct(private array $routes = [])
    {
    }

    public function dispatch(Request $request): Response
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        if (isset($this->routes[$method][$path])) {
            [$controller, $method] = $this->routes[$method][$path];
            $controller = new $controller();
            return $controller->$method($request);
        }

        return new Response(404, [], 'Not Found');
    }
}