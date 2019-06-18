<?php

namespace Stitcher\Nodes;

use Stitcher\Exceptions\ConfigurationError;
use Stitcher\Node;
use Stitcher\Nodes\Collection\Collection;
use Stitcher\Nodes\Markdown\Markdown;
use Stitcher\Nodes\Page\Page;
use Stitcher\Nodes\Yaml\Yaml;
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
            return Collection::make($value);
        }

        if (Str::endsWith(['.yaml', '.yml'], $value)) {
            return Yaml::make($value);
        }

        if (Str::endsWith(['.md'], $value)) {
            return Markdown::make($this->fs->makeFullPath($value));
        }

        throw ConfigurationError::unknownNode($value);
    }

    public function makePage(string $url, array $values): Page
    {
        return Page::make($url, $values);
    }
}
