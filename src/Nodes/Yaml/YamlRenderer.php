<?php

namespace Stitcher\Nodes\Yaml;

use Stitcher\Exceptions\ConfigurationError;
use Stitcher\Exceptions\InvalidNode;
use Stitcher\Node;
use Stitcher\NodeRenderer;
use Stitcher\Nodes\NodeFactory;
use Stitcher\Nodes\RendererFactory;
use Symfony\Component\Yaml\Parser;

class YamlRenderer implements NodeRenderer
{
    private Parser $parser;

    private NodeFactory $nodeFactory;

    private RendererFactory $rendererFactory;

    public function __construct(
        Parser $parser,
        NodeFactory $nodeFactory,
        RendererFactory $rendererFactory
    ) {
        $this->parser = $parser;
        $this->nodeFactory = $nodeFactory;
        $this->rendererFactory = $rendererFactory;
    }

    public function render(Node $node): array
    {
        if (! $node instanceof Yaml) {
            throw InvalidNode::node($node, Yaml::class);
        }

        $array = $this->parser->parse($node->yaml);

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
