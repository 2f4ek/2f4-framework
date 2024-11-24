<?php

namespace Framework2f4\Controller;

use Framework2f4\Http\Response;
use Psr\Log\LoggerInterface;

readonly class ExampleController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function testGet(): Response
    {
        $this->logger->info('Get Request');

        return new Response(200, [], 'Get response');
    }

    public function testPost(): Response
    {
        $this->logger->info('Post Request');

        return new Response(200, [], 'Post response');
    }

    public function testPut(): Response
    {
        $this->logger->info('Put Request');

        return new Response(200, [], 'Put response');
    }
}