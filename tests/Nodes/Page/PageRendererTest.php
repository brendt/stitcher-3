<?php

namespace Tests\Nodes\Page;

use Stitcher\Nodes\Page\Page;
use Stitcher\Nodes\Page\PageRenderer;
use Tests\TestCase;

class PageRendererTest extends TestCase
{
    private PageRenderer $pageRenderer;

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
            ],
        );

        $html = $this->pageRenderer->render($page);

        $this->assertStringStartsWith('<h1>md</h1>', $html);
    }

    /** @test */
    public function test_render_with_modifier()
    {
        $page = new Page(
            'template.twig',
            [
                'markdown' => 'markdown.md',
                'posts' => 'posts.yaml'
            ],
            [
                'collection' => 'posts'
            ]
        );

        $html = $this->pageRenderer->render($page);

        $this->assertStringStartsWith('<h1>md</h1>', $html);
    }
}
