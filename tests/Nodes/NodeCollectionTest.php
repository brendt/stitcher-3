<?php

namespace Tests\Nodes;

use Stitcher\Node;
use Stitcher\Nodes\NodeCollection;
use Tests\TestCase;

class NodeCollectionTest extends TestCase
{
    /** @test */
    public function test_keys()
    {
        $nodeCollection = new NodeCollection([
            'a' => new TestNode(),
            'b' => new TestNode(),
            'c' => new TestNode(),
        ]);

        $this->assertInstanceOf(TestNode::class, $nodeCollection['a']);

        $i = 0;

        foreach ($nodeCollection as $node) {
            $i++;

            $this->assertInstanceOf(TestNode::class, $node);
        }

        $this->assertEquals(3, $i);

        reset($nodeCollection);
    }
}

class TestNode implements Node
{
}

