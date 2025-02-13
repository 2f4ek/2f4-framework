<?php

namespace Framework2f4\Middleware;

use Framework2f4\Http\Response;
use Psr\Http\Message\ServerRequestInterface;

class RoleMiddleware implements MiddlewareInterface
{
    private string $requiredRole;

    public function __construct(string $requiredRole)
    {
        $this->requiredRole = $requiredRole;
    }

    public function process(ServerRequestInterface $request, callable $next): Response
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']->getRole() !== $this->requiredRole) {
            return new Response(403, [], 'Access Denied');
        }

        return $next($request);
    }
}