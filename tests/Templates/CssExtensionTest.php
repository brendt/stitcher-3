<?php

namespace Tests\Templates;

use Tests\TestCase;

class CssExtensionTest extends TestCase
{
    /** @test */
    public function test_inline()
    {
        $cssExtension = $this->container->cssExtension();

        $output = $cssExtension->inline('/style.scss');

        $this->assertStringContainsString('<style>', $output);
        $this->assertStringContainsString('</style>', $output);
        $this->assertStringContainsString('h1 {', $output);
        $this->assertStringContainsString('h1 > span {', $output);
    }

    /** @test */
    public function test_link()
    {
        $cssExtension = $this->container->cssExtension();

        $output = $cssExtension->link('/style.scss');

        $fs = $this->container->outputFilesystem();

        $this->assertEquals('<link rel="stylesheet" href="/./style.css" />', $output);
        $this->assertTrue($fs->exists('style.css'));
        $this->assertStringContainsString('h1 {', $fs->read('style.css'));
    }

    /** @test */
    public function test_minify()
    {
        $cssExtension = $this->container->cssExtension();

        $output = $cssExtension->minify()->inline('/style.scss');

        $this->assertStringContainsString('h1{color:red}', $output);
    }
}
