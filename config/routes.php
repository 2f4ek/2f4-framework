<?php

use Framework2f4\Controller\AdminController;
use Framework2f4\Controller\AuthController;
use Framework2f4\Controller\CartController;
use Framework2f4\Controller\ExampleController;
use Framework2f4\Controller\InventoryController;
use Framework2f4\Controller\UserController;
use Framework2f4\Middleware\AuthMiddleware;
use Framework2f4\Middleware\CSRFMiddleware;
use Framework2f4\Middleware\JWTMiddleware;
use Framework2f4\Middleware\RoleMiddleware;

$csrfMiddleware = new CSRFMiddleware();
$authMiddleware = new AuthMiddleware();
$jwtMiddleware = new JWTMiddleware();

return [
    '/' => [
        'GET' => [ExampleController::class, 'testGet', 'middleware' => false]
    ],
    '/json' => [
        'GET' => [ExampleController::class, 'testJson', 'middleware' => false],
    ],
    '/login' => [
        'POST' => [AuthController::class, 'loginWithSession', 'middleware' => [$csrfMiddleware]],
    ],
    '/jwt-login' => [
        'POST' => [AuthController::class, 'loginWithJWT', 'middleware' => [$csrfMiddleware]],
    ],
    '/logout' => [
        'POST' => [AuthController::class, 'logout', 'middleware' => false],
    ],
    '/admin' => [
        'GET' => [AdminController::class, 'index', 'middleware' => [$authMiddleware, new RoleMiddleware('admin')]],
    ],
    '/user' => [
        'POST' => [UserController::class, 'create', 'middleware' => false],
    ],
    '/user/{id}' => [
        'GET' => [UserController::class, 'read', 'middleware' => [
            $authMiddleware,
            new RoleMiddleware('admin')
        ]],
        'PUT' => [UserController::class, 'update', 'middleware' => [$authMiddleware]],
        'DELETE' => [UserController::class, 'delete', 'middleware' => [
            $authMiddleware,
            new RoleMiddleware('admin')
        ]],
    ],
    '/app-demo' => [
        'GET' => [ExampleController::class, 'appDemo', 'middleware' => false],
    ],
    '/cart' => [
        'POST' => [CartController::class, 'createCart', 'middleware' => [
            $csrfMiddleware,
            $authMiddleware
        ]],
    ],
    '/cart/item' => [
        'POST' => [CartController::class, 'addItem', 'middleware' => [
            $csrfMiddleware,
            $authMiddleware
        ]],
    ],
    '/cart/item/{id}' => [
        'DELETE' => [CartController::class, 'removeItem', 'middleware' => [
            $csrfMiddleware,
            $authMiddleware
        ]],
    ],
    '/cart/order' => [
        'POST' => [CartController::class, 'placeOrder', 'middleware' => [
            $csrfMiddleware,
            $authMiddleware
        ]],
    ],
    '/api/inventory' => [
        'POST' => [InventoryController::class, 'create', 'middleware' => [$jwtMiddleware]],
        'GET' => [InventoryController::class, 'list', 'middleware' => [$jwtMiddleware]],
    ],
    '/api/inventory/{id}' => [
        'DELETE' => [InventoryController::class, 'delete', 'middleware' => [$jwtMiddleware]],
        'PUT' => [InventoryController::class, 'update', 'middleware' => [$jwtMiddleware]],
    ],
    '/api/fetch-xml' => [
        'GET' => [ExampleController::class, 'fetchAndParseXML', 'middleware' => [$jwtMiddleware, $authMiddleware]],
    ],
];