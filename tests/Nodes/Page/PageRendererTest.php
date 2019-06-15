<?php

namespace Tests\Nodes\Page;

use Stitcher\Nodes\Page\Page;
use Tests\TestCase;

class PageRendererTest extends TestCase
{
    /** @var \Stitcher\Nodes\Page\PageRenderer */
    private $pageRenderer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pageRenderer = $this->container->pageRenderer();
    }

    /** @test */
    public function test_render()
    {
        $page = new Page(
            'template.twig',
            [
                'markdown' => 'markdown.md',
            ]
        );

        $html = $this->pageRenderer->render($page);

        $this->assertStringStartsWith('<h1>md</h1>', $html);
    }
}
