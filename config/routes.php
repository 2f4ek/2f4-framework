<?php

use Framework2f4\Controller\AdminController;
use Framework2f4\Controller\AuthController;
use Framework2f4\Controller\CartController;
use Framework2f4\Controller\ExampleController;
use Framework2f4\Controller\UserController;
use Framework2f4\Http\Response;
use Framework2f4\Middleware\AuthMiddleware;
use Framework2f4\Middleware\CSRFMiddleware;
use Framework2f4\Middleware\RoleMiddleware;

return [
    '/' => [
        'GET' => [ExampleController::class, 'testGet', 'middleware' => false],
        'POST' => [ExampleController::class, 'testPost', 'middleware' => false],
        'PUT' => [ExampleController::class, 'testPut'],
    ],
    '/login' => [
        'POST' => [AuthController::class, 'login', 'middleware' => [new CSRFMiddleware()]],
    ],
    '/logout' => [
        'POST' => [AuthController::class, 'logout', 'middleware' => false],
    ],
    '/admin' => [
        'GET' => [AdminController::class, 'index', 'middleware' => [new AuthMiddleware(), new RoleMiddleware('admin')]],
    ],
    '/user' => [
        'POST' => [UserController::class, 'create', 'middleware' => false],
    ],
    '/user/{id}' => [
        'GET' => [UserController::class, 'read', 'middleware' => [
            new AuthMiddleware(),
            new RoleMiddleware('admin')
        ]],
        'PUT' => [UserController::class, 'update', 'middleware' => [new AuthMiddleware()]],
        'DELETE' => [UserController::class, 'delete', 'middleware' => [
            new AuthMiddleware(),
            new RoleMiddleware('admin')
        ]],
    ],
    '/app-demo' => [
        'GET' => [ExampleController::class, 'appDemo', 'middleware' => false],
    ],
    '/cart' => [
        'POST' => [CartController::class, 'createCart', 'middleware' => [
            new CSRFMiddleware(),
            new AuthMiddleware()
        ]],
    ],
    '/cart/item' => [
        'POST' => [CartController::class, 'addItem', 'middleware' => [
            new CSRFMiddleware(),
            new AuthMiddleware()
        ]],
    ],
    '/cart/item/{id}' => [
        'DELETE' => [CartController::class, 'removeItem', 'middleware' => [
            new CSRFMiddleware(),
            new AuthMiddleware()
        ]],
    ],
    '/cart/order' => [
        'POST' => [CartController::class, 'placeOrder', 'middleware' => [
            new CSRFMiddleware(),
            new AuthMiddleware()
        ]],
    ],
];