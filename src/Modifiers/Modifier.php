<?php

namespace Stitcher\Modifiers;

use Stitcher\Nodes\NodeCollection;

interface Modifier
{
    public function getName(): string;

    public function modify(NodeCollection $pages): NodeCollection;
}
