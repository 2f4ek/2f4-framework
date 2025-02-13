<?php

namespace Framework2f4\Middleware;

use Framework2f4\Http\Response;
use Psr\Http\Message\ServerRequestInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, callable $next): Response
    {
        if (!isset($_SESSION['user'])) {
            return new Response(403, [], 'Access Denied');
        }

        return $next($request);
    }
}