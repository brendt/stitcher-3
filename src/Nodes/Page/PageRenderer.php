<?php

namespace Stitcher\Nodes\Page;

use Stitcher\Exceptions\InvalidNode;
use Stitcher\Modifiers\ModifierFactory;
use Stitcher\Node;
use Stitcher\NodeRenderer;
use Stitcher\Nodes\NodeCollection;
use Stitcher\Nodes\NodeFactory;
use Stitcher\Nodes\RendererFactory;
use Stitcher\Templates\TwigRenderer;

class PageRenderer implements NodeRenderer
{
    private NodeFactory $nodeFactory;

    private RendererFactory $rendererFactory;

    private ModifierFactory $modifierFactory;

    private TwigRenderer $twigRenderer;

    public function __construct(
        NodeFactory $nodeFactory,
        RendererFactory $rendererFactory,
        ModifierFactory $modifierFactory,
        TwigRenderer $twigRenderer
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->rendererFactory = $rendererFactory;
        $this->modifierFactory = $modifierFactory;
        $this->twigRenderer = $twigRenderer;
    }

    public function render(Node $page): array
    {
        if (! $page instanceof Page) {
            throw InvalidNode::node($page, Page::class);
        }

        $pages = array_map(function (Page $page) {
            $variables = $this->renderVariables($page->variables);

            return $this->twigRenderer->render($page->template, $variables);
        }, $this->modifyPage($page)->toArray());

        return $pages;
    }

    private function modifyPage(Page $page): NodeCollection
    {
        $pages = new NodeCollection([$page->url => $page]);

        foreach ($page->modifiers as $modifierName => $modifierConfig) {
            $modifier = $this->modifierFactory->make($modifierName, $modifierConfig);

            $pages = $modifier->modify($pages);
        }

        return $pages;
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
