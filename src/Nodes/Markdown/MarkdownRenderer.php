<?php

namespace Stitcher\Nodes\Markdown;

use League\CommonMark\CommonMarkConverter;
use Stitcher\Exception\InvalidNode;
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

    public function render(Node $markdown): string
    {
        if (! $markdown instanceof Markdown) {
            throw InvalidNode::node($markdown, Markdown::class);
        }

        return $this->converter->convertToHtml($markdown->markdown);
    }
}
