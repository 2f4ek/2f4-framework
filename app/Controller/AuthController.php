<?php

namespace Framework2f4\Controller;

use Framework2f4\Http\Response;
use Framework2f4\Model\User;

class AuthController
{
    private array $users = [
        'admin' => ['password' => 'adminpass', 'role' => 'admin'],
        'user' => ['password' => 'userpass', 'role' => 'user']
    ];

    public function login(): Response
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (isset($this->users[$username]) && $this->users[$username]['password'] === $password) {
            session_start();
            $_SESSION['user'] = new User(1, $username, $password, $this->users[$username]['role']);
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
        return new Response(200, [], 'Logout successful');
    }
}