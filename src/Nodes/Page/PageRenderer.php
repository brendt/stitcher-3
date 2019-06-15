<?php

namespace Stitcher\Nodes\Page;

use Stitcher\Exceptions\InvalidNode;
use Stitcher\Node;
use Stitcher\NodeRenderer;
use Stitcher\Nodes\NodeFactory;
use Stitcher\Nodes\RendererFactory;
use Twig\Environment as TwigEnvironment;

class PageRenderer implements NodeRenderer
{
    private NodeFactory $nodeFactory;

    private RendererFactory $rendererFactory;

    private TwigEnvironment $twig;

    public function __construct(
        NodeFactory $nodeFactory,
        RendererFactory $rendererFactory,
        TwigEnvironment $twig
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->rendererFactory = $rendererFactory;
        $this->twig = $twig;
    }

    public function render(Node $node): string
    {
        if (! $node instanceof Page) {
            throw InvalidNode::node($node, Page::class);
        }

        $variables = [];

        foreach ($node->variables as $key => $variable) {
            $variableNode = $this->nodeFactory->make($variable);

            $childRenderer = $this->rendererFactory->make($variableNode);

            $variables[$key] = $childRenderer->render($variableNode);
        }

        return $this->twig->render($node->template, $variables);
    }
}
