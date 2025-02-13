<?php

namespace Framework2f4\Controller;

use Framework2f4\Http\Request;
use Framework2f4\Http\Response;
use Framework2f4\Repository\UserRepository;

class AuthController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function login(Request $request): Response
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