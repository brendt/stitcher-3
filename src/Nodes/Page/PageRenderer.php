<?php

namespace Stitcher\Nodes\Page;

use Stitcher\Exception\InvalidNode;
use Stitcher\Node;
use Stitcher\NodeRenderer;
use Stitcher\Nodes\RendererFactory;

class PageRenderer implements NodeRenderer
{
    /** @var \Stitcher\Nodes\RendererFactory */
    private $factory;

    public function __construct(RendererFactory $factory)
    {
        $this->factory = $factory;
    }

    public function render(Node $page): void
    {
        if (! $page instanceof Page) {
            throw InvalidNode::node($page, Page::class);
        }

        foreach ($page->variables as $key => $variableNode) {
            $childRenderer = $this->factory->make($variableNode);

            $page->variables[$key] = $childRenderer->render($variableNode);
        }
    }
}
