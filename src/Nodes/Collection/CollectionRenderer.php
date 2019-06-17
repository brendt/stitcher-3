<?php

namespace Stitcher\Nodes\Collection;

use Stitcher\Exceptions\ConfigurationError;
use Stitcher\Exceptions\InvalidNode;
use Stitcher\Node;
use Stitcher\NodeRenderer;
use Stitcher\Nodes\NodeFactory;
use Stitcher\Nodes\RendererFactory;

class CollectionRenderer implements NodeRenderer
{
    protected NodeFactory $nodeFactory;

    protected RendererFactory $rendererFactory;

    public function __construct(
        NodeFactory $nodeFactory,
        RendererFactory $rendererFactory
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->rendererFactory = $rendererFactory;
    }

    public function render(Node $node): array
    {
        if (! $node instanceof Collection) {
            throw InvalidNode::node($node, Collection::class);
        }

        return $this->renderArray($node->collection);
    }

    protected function renderArray(array $array): array
    {
        foreach ($array as $key => $item) {
            try {
                $node = $this->nodeFactory->make($item);
            } catch (ConfigurationError $exception) {
                continue;
            }

            $nodeRenderer = $this->rendererFactory->make($node);

            $array[$key] = $nodeRenderer->render($node);
        }

        return $array;
    }
}
