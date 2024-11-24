<?php

return [
    '/' => [
        'GET' => [Framework2f4\Controller\ExampleController::class, 'testGet', 'middleware' => false],
        'POST' => [Framework2f4\Controller\ExampleController::class, 'testPost', 'middleware' => false],
        'PUT' => [
            Framework2f4\Controller\ExampleController::class,
            'testPut'
        ],
    ],
];