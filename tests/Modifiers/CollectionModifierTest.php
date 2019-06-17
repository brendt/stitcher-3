<?php

namespace Tests\Modifiers;

use Stitcher\Modifiers\CollectionModifier;
use Stitcher\Nodes\NodeCollection;
use Stitcher\Nodes\Page\Page;
use Tests\TestCase;

class CollectionModifierTest extends TestCase
{
    /** @test */
    public function test_modify()
    {
        $page = new Page('', [
            'post' => 'posts.yaml',
        ]);

        $modifier = $this->container->collectionModifier('post', 'title');

        $pages = $modifier->modify(
            new NodeCollection(['/blog/{post}' => $page])
        );

        $this->assertCount(2, $pages);

        $this->assertArrayHasKey('a', $pages);
        $this->assertArrayHasKey('b', $pages);

        $this->assertEquals('a', $pages['a']->variables['post']['title']);
        $this->assertEquals('b', $pages['b']->variables['post']['title']);
    }
}
