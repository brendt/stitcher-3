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
            'id',
            'template.twig',
            [
                'markdown' => 'markdown.md',
            ],
        );

        $renderedPages = $this->pageRenderer->render($page);

        $this->assertStringStartsWith('<h1>md</h1>', $renderedPages['id']);
    }

    /** @test */
    public function test_render_with_modifier()
    {
        $page = new Page(
            '/blog/{post}',
            'detail.twig',
            [
                'post' => 'posts.yaml',
            ],
            [
                'collection' => [
                    'variable' => 'post',
                    'field' => 'title',
                ],
            ]
        );

        $renderedPages = $this->pageRenderer->render($page);

        $this->assertStringStartsWith('<h1>a</h1>', $renderedPages['/blog/a']);
        $this->assertStringContainsString('<h2>body</h2>', $renderedPages['/blog/a']);

        $this->assertStringStartsWith('<h1>b</h1>', $renderedPages['/blog/b']);
        $this->assertStringContainsString('<h2>body</h2>', $renderedPages['/blog/b']);

    }
}
