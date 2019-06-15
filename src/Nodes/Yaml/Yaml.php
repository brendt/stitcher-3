<?php

namespace Stitcher\Nodes\Yaml;

use Stitcher\Node;

class Yaml implements Node
{
    public string $yaml;

    public static function make(string $file): Yaml
    {
        return new self(file_get_contents($file));
    }

    public function __construct(string $yaml)
    {
        $this->yaml = $yaml;
    }
}
