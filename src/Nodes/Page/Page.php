<?php

namespace Stitcher\Nodes\Page;

use Stitcher\Node;
use Stitcher\Nodes\NodeCollection;

class Page implements Node
{
    public string $template;

    public NodeCollection $variables;

    public function __construct(
        string $template,
        NodeCollection $variables
    ) {
        $this->template = $template;
        $this->variables = $variables;
    }
}
