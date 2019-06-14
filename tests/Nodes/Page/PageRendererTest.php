<?php

namespace Tests\Nodes\Page;

use Stitcher\Nodes\Page\PageRenderer;
use Tests\TestCase;

class PageRendererTest extends TestCase
{
    /** @var \Stitcher\Nodes\Page\PageRenderer */
    private $pageRenderer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pageRenderer = new PageRenderer(
            $this->container->rendererFactory()
        );
    }

    /** @test */
    public function a()
    {

    }
}
