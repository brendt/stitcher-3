<?php

namespace Stitcher\Nodes;

use Stitcher\Exceptions\ConfigurationError;
use Stitcher\Node;
use Stitcher\Nodes\Markdown\Markdown;
use Stitcher\Nodes\Page\Page;
use Stitcher\Services\Filesystem;
use Stitcher\Services\Str;

class NodeFactory
{
    private Filesystem $fs;

    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
    }

    public function make($value): Node
    {
        if (is_array($value)) {
            return Page::make($value);
        }

        if (Str::endsWith(['.yaml', '.yml'], $value)) {
            //
        }

        if (Str::endsWith(['.md'], $value)) {
            return Markdown::make($this->fs->makeFullPath($value));
        }

        throw ConfigurationError::unknownNode($value);
    }
}
