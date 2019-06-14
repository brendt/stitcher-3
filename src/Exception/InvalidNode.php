<?php

namespace Stitcher\Exception;

use Exception;
use Stitcher\Node;

class InvalidNode extends Exception
{
    public static function node(Node $node, string $expected): InvalidNode
    {
        return new self("Expected {$expected}, instead got " . get_class($node));
    }
}
