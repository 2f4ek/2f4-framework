<?php

namespace Framework2f4;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Framework2f4\Http\Response;
use Psr\Log\LoggerInterface;

readonly class Route
{
    public function __construct(private Container $container, private array $routes = [])
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function dispatch(Request $request): Response
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        if (isset($this->routes[$path][$method])) {
            [$controller, $method] = $this->routes[$path][$method];
            $controller = new $controller($this->container->get(LoggerInterface::class));
            return $controller->$method($request);
        }

        return new Response(404, [], 'Not Found');
    }
}