<?php

namespace Framework2f4\Controller;

use Framework2f4\Http\Response;

class AdminController
{
    public function index(): Response
    {
        return new Response(200, [], 'Admin Dashboard');
    }
}