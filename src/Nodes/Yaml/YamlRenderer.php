<?php

namespace Stitcher\Nodes\Yaml;

use Stitcher\Exceptions\InvalidNode;
use Stitcher\Node;
use Stitcher\Nodes\Collection\CollectionRenderer;
use Stitcher\Nodes\NodeFactory;
use Stitcher\Nodes\RendererFactory;
use Symfony\Component\Yaml\Parser as YamlParser;

class YamlRenderer extends CollectionRenderer
{
    private YamlParser $yamlParser;

    public function __construct(
        YamlParser $yamlParser,
        NodeFactory $nodeFactory,
        RendererFactory $rendererFactory
    ) {
        parent::__construct($nodeFactory, $rendererFactory);

        $this->yamlParser = $yamlParser;
    }

    public function render(Node $node): array
    {
        if (! $node instanceof Yaml) {
            throw InvalidNode::node($node, Yaml::class);
        }

        $array = $this->yamlParser->parse($node->yaml);

        return parent::renderArray($array);
    }
}
