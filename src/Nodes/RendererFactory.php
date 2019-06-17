<?php

namespace Stitcher\Nodes;

use Exception;
use Stitcher\Container\Container;
use Stitcher\Node;
use Stitcher\NodeRenderer;
use Stitcher\Nodes\Collection\Collection;
use Stitcher\Nodes\Markdown\Markdown;
use Stitcher\Nodes\Page\Page;
use Stitcher\Nodes\Yaml\Yaml;

final class RendererFactory
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function make(Node $node): NodeRenderer
    {
        if ($node instanceof Page) {
            return $this->container->pageRenderer();
        }

        if ($node instanceof Markdown) {
            return $this->container->markdownRenderer();
        }

        if ($node instanceof Yaml) {
            return $this->container->yamlRenderer();
        }

        if ($node instanceof Collection) {
            return $this->container->collectionRenderer();
        }

        throw new Exception('Could not find any renderer for node with class ' . get_class($node));
    }
}
