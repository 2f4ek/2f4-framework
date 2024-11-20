<?php

namespace Framework2f4\Controller;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;

class TestController
{
    public function testGet(): ResponseInterface
    {
        return new Response(200, [], 'Get response');
    }

    public function testPost(): ResponseInterface
    {
        return new Response(200, [], 'Post response');
    }

    public function testPut(): ResponseInterface
    {
        return new Response(200, [], 'Put response');
    }
}