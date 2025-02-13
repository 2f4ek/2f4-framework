<?php

namespace Framework2f4\Controller;

use Framework2f4\Http\Response;
use Framework2f4\Model\User;

class AuthController
{
    // This is just a simple example. admin - aminpass, user - userpass
    private array $users = [
        'admin' => ['password' => '$2y$10$PwTqQBP0QTKjMHSH1gRq3OOjYYahKxIKKGseB.zkBpQohrZZf.UtW', 'role' => 'admin'],
        'user' => ['password' => '$2y$10$tiPaV6CGT/CyyMYK4exGNuwieHZKOZv3FlE5Vb0AuP9wU5E/d8.3e', 'role' => 'user']
    ];

    public function login(): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrfToken = $_POST['csrf_token'] ?? '';
            if (!$csrfToken || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
                return new Response(403, [], 'Invalid CSRF token');
            }

            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (isset($this->users[$username]) && password_verify($password, $this->users[$username]['password'])) {
                $_SESSION['user'] = new User(1, $username, $password, $this->users[$username]['role']);
                return new Response(200, [], 'Login successful');
            }

            return new Response(401, [], 'Invalid credentials');
        }

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return new Response(200, [], 'CSRF token generated');
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