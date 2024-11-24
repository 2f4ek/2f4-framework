<?php

namespace Framework2f4\Middleware;

use Framework2f4\Http\Response;
use Psr\Http\Message\ServerRequestInterface;

class DefaultMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, callable $next): Response
    {
        $proceed = $request->getHeader('proceed');
        if ($proceed) {
            return $next($request);
        }

        return new Response(403, [], 'Access Denied');
    }
}