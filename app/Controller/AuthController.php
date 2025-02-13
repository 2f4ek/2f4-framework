<?php

namespace Framework2f4\Controller;

use Firebase\JWT\JWT;
use Framework2f4\Http\Request;
use Framework2f4\Http\Response;
use Framework2f4\Repository\UserRepository;

class AuthController
{
    private string $secretKey;

    public function __construct(private $userRepository = new UserRepository())
    {
        $this->secretKey = $_ENV['JWT_SECRET_KEY'];
    }

    public function loginWithJWT(Request $request): Response
    {
        $requestData = $request->getParsedBody();
        $username = $requestData['username'] ?? '';
        $password = $requestData['password'] ?? '';

        $user = $this->userRepository->findByUsername($username);

        if ($user && password_verify($password, $user->getPassword())) {
            $issuedAt = new \DateTimeImmutable();
            $expire = $issuedAt->modify('+1 day')->getTimestamp();
            $payload = [
                'iat' => $issuedAt->getTimestamp(),
                'iss' => 'localhost',
                'nbf' => $issuedAt->getTimestamp(),
                'exp' => $expire,
                'userName' => $username,
            ];

            $jwt = JWT::encode($payload, $this->secretKey, 'HS256');

            return new Response(200, ['Content-Type' => 'application/json'], json_encode(['token' => $jwt]));
        }

        return new Response(401, [], 'Invalid credentials');
    }

    public function loginWithSession(Request $request): Response
    {
        $requestData = $request->getParsedBody();
        $username = $requestData['username'] ?? '';
        $password = $requestData['password'] ?? '';

        $user = $this->userRepository->findByUsername($username);

        if ($user && password_verify($password, $user->getPassword())) {
            $_SESSION['user'] = $user;
            return new Response(200, [], 'Login successful');
        }

        return new Response(401, [], 'Invalid credentials');
    }

    public function logout(): Response
    {
        if (!isset($_SESSION['user'])) {
            return new Response(401, [], 'You are not logged in');
        }

        unset($_SESSION['user']);
        session_destroy();
        return new Response(200, [], 'Logout successful');
    }
}