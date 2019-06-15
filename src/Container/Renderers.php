<?php

namespace Stitcher\Container;

use Stitcher\Nodes\Markdown\MarkdownRenderer;
use Stitcher\Nodes\Page\PageRenderer;
use Stitcher\Nodes\Yaml\YamlRenderer;

/**
 * @mixin \Stitcher\Container\Container
 */
trait Renderers
{
    public function markdownRenderer(): MarkdownRenderer
    {
        return new MarkdownRenderer(
            $this->filesystem(),
            $this->markdownParser()
        );
    }

    public function pageRenderer(): PageRenderer
    {
        return new PageRenderer(
            $this->nodeFactory(),
            $this->rendererFactory(),
            $this->twigParser()
        );
    }

    public function yamlRenderer(): YamlRenderer
    {
        return new YamlRenderer(
            $this->yamlParser(),
            $this->nodeFactory(),
            $this->rendererFactory(),
        );
    }
}
