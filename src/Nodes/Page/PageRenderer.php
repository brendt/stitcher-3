<?php

namespace Stitcher\Nodes\Page;

use Stitcher\Exceptions\InvalidNode;
use Stitcher\Modifiers\ModifierFactory;
use Stitcher\Node;
use Stitcher\NodeRenderer;
use Stitcher\Nodes\NodeCollection;
use Stitcher\Nodes\NodeFactory;
use Stitcher\Nodes\RendererFactory;
use Twig\Environment as TwigEnvironment;

class PageRenderer implements NodeRenderer
{
    private NodeFactory $nodeFactory;

    private RendererFactory $rendererFactory;

    private ModifierFactory $modifierFactory;

    private TwigEnvironment $twig;

    public function __construct(
        NodeFactory $nodeFactory,
        RendererFactory $rendererFactory,
        ModifierFactory $modifierFactory,
        TwigEnvironment $twig
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->rendererFactory = $rendererFactory;
        $this->modifierFactory = $modifierFactory;
        $this->twig = $twig;
    }

    public function render(Node $node): string
    {
        if (! $node instanceof Page) {
            throw InvalidNode::node($node, Page::class);
        }

        $pages = $this->modifyPage($node);

        $variables = $this->renderVariables($node->variables);

        return $this->twig->render($node->template, $variables);
    }

    private function modifyPage(Page $page): NodeCollection
    {
        foreach ($page->modifiers as $modifierName => $modifierConfig) {
            $modifier = $this->modifierFactory->make($modifierName, $modifierConfig);

            dd($modifier);
        }
    }

    private function renderVariables(array $nodeVariables): array
    {
        $variables = [];

        foreach ($nodeVariables as $key => $variable) {
            $variableNode = $this->nodeFactory->make($variable);

            $childRenderer = $this->rendererFactory->make($variableNode);

            $variables[$key] = $childRenderer->render($variableNode);
        }

        return $variables;
    }
}
