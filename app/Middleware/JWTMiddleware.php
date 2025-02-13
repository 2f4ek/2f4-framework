<?php

namespace Framework2f4\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Framework2f4\Http\Response;
use Framework2f4\Model\User;
use Psr\Http\Message\ServerRequestInterface;

class JWTMiddleware implements MiddlewareInterface
{
    private string $secretKey;

    public function __construct()
    {
        $this->secretKey = $_ENV['JWT_SECRET_KEY'];
    }

    public function process(ServerRequestInterface $request, callable $next): Response
    {
        $authHeader = $request->getHeader('Authorization');
        if (is_array($authHeader)) {
            $authHeader = $authHeader[0];
        }
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $jwt = $matches[1];
            $decoded = JWT::decode($jwt, new Key($this->secretKey, 'HS256'));
            $user = User::findByName($decoded->userName);
            if ($user) {
                $_SESSION['user'] = $user;
                return $next($request);
            }

            return new Response(401, [], 'Invalid token');
        }
        return new Response(401, [], 'Authorization header not found');
    }
}