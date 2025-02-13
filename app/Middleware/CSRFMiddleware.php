<?php

namespace Framework2f4\Middleware;

use Framework2f4\Http\Response;
use Psr\Http\Message\ServerRequestInterface;

class CSRFMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, callable $next): Response
    {
        $requestData = $request->getParsedBody();
        $csrfToken = $requestData['csrf_token'] ?? '';
        if (!$csrfToken || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
            return new Response(403, [], 'Invalid CSRF token');
        }

        return $next($request);
    }
}