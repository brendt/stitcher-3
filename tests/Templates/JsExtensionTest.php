<?php

namespace Tests\Templates;

use Tests\TestCase;

class JsExtensionTest extends TestCase
{
    /** @test */
    public function test_inline()
    {
        $extension = $this->container->jsExtension();

        $output = $extension->inline('/script.js');

        $this->assertStringContainsString('<script>', $output);
        $this->assertStringContainsString('</script>', $output);
        $this->assertStringContainsString('console.log(foo)', $output);
    }

    /** @test */
    public function test_minify()
    {
        $extension = $this->container->jsExtension();

        $output = $extension->minify()->inline('/script.js');

        $this->assertCount(2, explode(PHP_EOL, $output));
    }

    /** @test */
    public function test_link()
    {
        $cssExtension = $this->container->jsExtension();

        $output = $cssExtension->link('/script.js');

        $fs = $this->container->outputFilesystem();

        $this->assertEquals('<script src="/script.js"></script>', $output);
        $this->assertTrue($fs->exists('script.js'));
        $this->assertStringContainsString('const foo', $fs->read('script.js'));
    }

    /** @test */
    public function test_link_defer()
    {
        $cssExtension = $this->container->jsExtension();

        $output = $cssExtension->defer()->link('/script.js');

        $this->assertStringContainsString('defer', $output);
    }

    /** @test */
    public function test_link_async()
    {
        $cssExtension = $this->container->jsExtension();

        $output = $cssExtension->async()->link('/script.js');

        $this->assertStringContainsString('async', $output);
    }
}
