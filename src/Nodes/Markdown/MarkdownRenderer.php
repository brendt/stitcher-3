<?php

namespace Stitcher\Nodes\Markdown;

use League\CommonMark\CommonMarkConverter;
use Stitcher\Exceptions\InvalidNode;
use Stitcher\Node;
use Stitcher\NodeRenderer;
use Stitcher\Services\Filesystem;

class MarkdownRenderer implements NodeRenderer
{
    private Filesystem $filesystem;

    private CommonMarkConverter $converter;

    public function __construct(
        Filesystem $filesystem,
        CommonMarkConverter $converter
    ) {
        $this->converter = $converter;
        $this->filesystem = $filesystem;
    }

    public function render(Node $node): string
    {
        if (! $node instanceof Markdown) {
            throw InvalidNode::node($node, Markdown::class);
        }

        return $this->converter->convertToHtml($node->markdown);
    }
}
