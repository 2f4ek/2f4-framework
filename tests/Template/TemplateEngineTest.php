<?php

namespace Framework2f4\Tests\Template;

use Framework2f4\Template\TemplateEngine;
use PHPUnit\Framework\TestCase;

class TemplateEngineTest extends TestCase
{
    private TemplateEngine $templateEngine;

    protected function setUp(): void
    {
        $this->templateEngine = new TemplateEngine(__DIR__.'/views');
    }

    public function testRenderTemplateWithNoVariables(): void
    {
        $html = $this->templateEngine->render('test');

        $this->assertStringContainsString('<title></title>', $html);
        $this->assertStringContainsString('<h1></h1>', $html);
        $this->assertStringContainsString('<p></p>', $html);
    }

    public function testRenderTemplateWithSpecialCharacters(): void
    {
        $html = $this->templateEngine->render('example', [
            'title' => '<Test & Page>',
            'heading' => 'Welcome to the <Test Page>',
            'content' => 'This is a simple test page with special characters: <, >, &, "'
        ]);

        $this->assertStringContainsString('<title>&lt;Test &amp; Page&gt;</title>', $html);
        $this->assertStringContainsString('<h1>Welcome to the &lt;Test Page&gt;</h1>', $html);
        $this->assertStringContainsString('<p>This is a simple test page with special characters: &lt;, &gt;, &amp;, &quot;</p>', $html);
    }

    public function testRenderNonExistentTemplate(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Template not found: /app/tests/Template/views/nonexistent.php');

        $this->templateEngine->render('nonexistent');
    }

    public function testRenderTemplateWithNestedTemplates(): void
    {
        $html = $this->templateEngine->render('nested', [
            'title' => 'Nested Template',
            'heading' => 'This is a nested template',
            'content' => 'Content of the nested template'
        ]);

        $this->assertStringContainsString('<header>Header Content</header>', $html);
        $this->assertStringContainsString('<h1>This is a nested template</h1>', $html);
        $this->assertStringContainsString('<footer>Footer Content</footer>', $html);
    }
}
