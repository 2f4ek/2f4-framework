<?php

namespace Framework2f4\Tests\Unit\Middleware;

use Framework2f4\Http\Response;
use Framework2f4\Middleware\DefaultMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class DefaultMiddlewareTest extends TestCase
{
    public function testProcessContinuesOnValidHeader(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $middleware = new DefaultMiddleware();

        $request->method('getHeader')->willReturn(['1']);
        $next = function ($request) {
            return new Response(200, [], 'Request proceeded');
        };

        $response = $middleware->process($request, $next);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Request proceeded', $response->getBody());
    }

    public function testProcessStopsOnInvalidHeader(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $middleware = new DefaultMiddleware();

        $request->method('getHeader')->willReturn([]);
        $next = function ($request) {
            return new Response(200, [], 'Request should not proceed');
        };

        $response = $middleware->process($request, $next);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('Access Denied', $response->getBody());
    }
}