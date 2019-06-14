<?php

namespace Tests\Nodes\Markdown;

use Stitcher\Nodes\Markdown\Markdown;
use Stitcher\Nodes\Markdown\MarkdownRenderer;
use Tests\TestCase;

class MarkdownRendererTest extends TestCase
{
    /** @var MarkdownRenderer */
    private MarkdownRenderer $markdownRenderer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->markdownRenderer = $this->container->markdownRenderer();
    }

    /** @test */
    public function test_render()
    {
        $markdown = new Markdown('# md');

        $html = $this->markdownRenderer->render($markdown);

        $this->assertEquals('<h1>md</h1>', trim($html));
    }
}
