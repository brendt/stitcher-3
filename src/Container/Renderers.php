<?php

namespace Stitcher\Container;

use Stitcher\Nodes\Markdown\MarkdownRenderer;
use Stitcher\Nodes\Page\PageRenderer;

/**
 * @mixin \Stitcher\Container\Container
 */
trait Renderers
{
    public function markdownRenderer(): MarkdownRenderer
    {
        return new MarkdownRenderer(
            $this->filesystem(),
            $this->markdownConverter()
        );
    }

    public function pageRenderer(): PageRenderer
    {
        return new PageRenderer($this->rendererFactory());
    }
}
