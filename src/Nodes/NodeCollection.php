<?php

namespace Stitcher\Nodes;

use ArrayAccess;
use Iterator;
use Stitcher\Node;

final class NodeCollection implements Iterator, ArrayAccess
{
    private array $nodes;

    private int $key = 0;

    public function __construct(Node ...$nodes)
    {
        $this->nodes = array_values($nodes);
    }

    public function current(): Node
    {
        return $this->nodes[$this->key];
    }

    public function next(): void
    {
        $this->key++;
    }

    public function key(): int
    {
        return $this->key;
    }

    public function valid(): bool
    {
        return array_key_exists($this->key, $this->nodes);
    }

    public function rewind(): void
    {
        $this->key = 0;
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->nodes);
    }

    public function offsetGet($offset): Node
    {
        return $this->nodes[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->nodes[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->nodes[$offset]);
    }
}
