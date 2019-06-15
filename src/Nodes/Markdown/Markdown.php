<?php

namespace Stitcher\Nodes\Markdown;

use Stitcher\Node;

class Markdown implements Node
{
    public string $markdown;

    public static function make(string $file): Markdown
    {
        return new self(file_get_contents($file));
    }

    public function __construct(string $markdown)
    {
        $this->markdown = $markdown;
    }
}
