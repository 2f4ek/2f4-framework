<?php

namespace Framework2f4\Tests\Integration;

use Framework2f4\Controller\ExampleController;
use Framework2f4\Http\ServerRequest;
use PHPUnit\Framework\TestCase;
use Framework2f4\Route;
use Framework2f4\Http\Uri;

class RouteTest extends TestCase
{
    private Route $route;

    protected function setUp(): void
    {
        $this->route = new Route();
    }

    public function testHomepageReturnsCorrectResponse(): void
    {
        $this->route->addRoute('GET', '/', [ExampleController::class, 'testGet']);

        $request = new ServerRequest('GET', new Uri('/'));
        $response = $this->route->dispatch($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Get response', (string)$response->getBody());
    }

    public function testNotFoundResponse(): void
    {
        $request = new ServerRequest('GET', new Uri('/not-found'));
        $response = $this->route->dispatch($request);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Not Found', (string)$response->getBody());
    }

    public function testMethodNotAllowed(): void
    {
        $this->route->addRoute('GET', '/data', [ExampleController::class, 'testGet']);

        $request = new ServerRequest('POST', new Uri('/data'));
        $response = $this->route->dispatch($request);

        $this->assertEquals(404, $response->getStatusCode());
    }
}