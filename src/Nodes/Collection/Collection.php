<?php

namespace Stitcher\Nodes\Collection;

use Stitcher\Node;

class Collection implements Node
{
    public array $collection;

    public static function make(array $collection): Collection
    {
        return new self($collection);
    }

    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }
}
