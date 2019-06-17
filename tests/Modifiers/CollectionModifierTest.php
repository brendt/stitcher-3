<?php

namespace Tests\Modifiers;

use Stitcher\Nodes\NodeCollection;
use Stitcher\Nodes\Page\Page;
use Tests\TestCase;

class CollectionModifierTest extends TestCase
{
    /** @test */
    public function test_modify()
    {
        $page = new Page('/blog/{post}', '', [
            'post' => 'posts.yaml',
        ]);

        $modifier = $this->container->collectionModifier('post', 'title');

        $pages = $modifier->modify(
            new NodeCollection([$page->url => $page])
        );

        $this->assertCount(2, $pages);

        $this->assertArrayHasKey('/blog/a', $pages);
        $this->assertArrayHasKey('/blog/b', $pages);

        $this->assertEquals('a', $pages['/blog/a']->variables['post']['title']);
        $this->assertEquals('b', $pages['/blog/b']->variables['post']['title']);
    }
}
