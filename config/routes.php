<?php

use Framework2f4\Controller\AdminController;
use Framework2f4\Controller\AuthController;
use Framework2f4\Controller\ExampleController;
use Framework2f4\Controller\UserController;
use Framework2f4\Http\Response;
use Framework2f4\Middleware\AuthMiddleware;
use Framework2f4\Middleware\RoleMiddleware;

return [
    '/' => [
        'GET' => [ExampleController::class, 'testGet', 'middleware' => false],
        'POST' => [ExampleController::class, 'testPost', 'middleware' => false],
        'PUT' => [ExampleController::class, 'testPut'],
    ],
    '/login' => [
        'POST' => [AuthController::class, 'login', 'middleware' => false],
    ],
    '/logout' => [
        'POST' => [AuthController::class, 'logout', 'middleware' => false],
    ],
    '/admin' => [
        'GET' => [AdminController::class, 'index', 'middleware' => [AuthMiddleware::class, new RoleMiddleware('admin')]],
    ],
    '/user' => [
        'GET' => [UserController::class, 'index', 'middleware' => [AuthMiddleware::class, new RoleMiddleware('user')]],
    ],
    '/example-login' => [
        'GET' => [ExampleController::class, 'testLogin', 'middleware' => false],
    ],
];