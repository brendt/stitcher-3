<?php

namespace Tests\Actions;

use Tests\TestCase;

class RenderActionTest extends TestCase
{
    /** @test */
    public function test_invoke()
    {
        $action = $this->container->renderAction();

        $action('site.yaml');

        $tests = [
            'output/test.html',
            'output/a/b/c.html',
            'output/blog/a.html',
            'output/blog/b.html',
        ];

        foreach ($tests as $path) {
            $this->assertTrue($this->fs->exists($this->fs->makeFullPath($path)));
        }
    }
}
