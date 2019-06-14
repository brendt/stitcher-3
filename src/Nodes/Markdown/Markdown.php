<?php

namespace Stitcher\Nodes\Markdown;

use Stitcher\Node;

class Markdown implements Node
{
    public string $markdown;

    public static function makeFromFile(string $path): Markdown
    {
        return new self(file_get_contents($path));
    }

    public function __construct(string $markdown)
    {
        $this->markdown = $markdown;
    }
}
