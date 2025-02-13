<?php

namespace Framework2f4\Controller;

use Framework2f4\Http\Response;
use Framework2f4\Model\Cart;
use Framework2f4\Model\CartItem;
use Framework2f4\Model\Order;
use Framework2f4\Model\Product;
use Framework2f4\Template\TemplateEngine;

readonly class ExampleController
{
    public function __construct(
        private TemplateEngine $templateEngine = new TemplateEngine(__DIR__ . '/../../views')
    )
    {
    }

    public function testGet(): Response
    {
        $html = $this->templateEngine->render('example', [
            'title' => 'Test Page',
            'heading' => 'Welcome to the Test Page',
            'content' => 'This is a simple test page.'
        ]);
        return Response::html($html);
    }

    public function testJson(): Response
    {
        $data = [
            'message' => 'This is a JSON response',
            'status' => 'success'
        ];

        return Response::json($data);
    }

    public function appDemo(): Response
    {
        $html = $this->templateEngine->render('app-demo', [
            'csrfToken' => $_SESSION['csrf_token'] ?? '',
            'products' => Product::all(),
            'carts' => Cart::where('user_id', $_SESSION['user']->id),
            'user' => $_SESSION['user'],
            'cartItems' => CartItem::all(),
            'orders' => Order::all()
        ]);

        return Response::html($html);
    }

    public function fetchAndParseXML(): Response
    {
        //TODO: resource is not available
        $url = 'https://thetestrequest.com/authors';
        return Response::json(['url' => $url]);
    }
}