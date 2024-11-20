<?php

namespace Framework2f4\Controller;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;

readonly class TestController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function testGet(): ResponseInterface
    {
        $this->logger->info('Get Request');
        
        return new Response(200, [], 'Get response');
    }

    public function testPost(): ResponseInterface
    {
        $this->logger->info('Post Request');

        return new Response(200, [], 'Post response');
    }

    public function testPut(): ResponseInterface
    {
        $this->logger->info('Put Request');

        return new Response(200, [], 'Put response');
    }
}