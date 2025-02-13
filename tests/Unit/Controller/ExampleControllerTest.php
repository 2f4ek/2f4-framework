<?php

namespace Framework2f4\Tests\Unit\Controller;

use Framework2f4\Controller\ExampleController;
use Framework2f4\Http\Response;
use PHPUnit\Framework\TestCase;

class ExampleControllerTest extends TestCase
{
    private ExampleController $controller;

    protected function setUp(): void
    {
        $this->controller = new ExampleController();
    }

    public function testGetResponse(): void
    {
        $response = $this->controller->testGet();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
