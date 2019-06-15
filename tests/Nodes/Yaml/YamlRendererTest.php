<?php

namespace Tests\Nodes\Yaml;

use Stitcher\Nodes\Yaml\Yaml;
use Stitcher\Nodes\Yaml\YamlRenderer;
use Tests\TestCase;

class YamlRendererTest extends TestCase
{
    /** @var \Stitcher\Nodes\Yaml\YamlRenderer */
    private $yamlRenderer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->yamlRenderer = $this->container->yamlRenderer();
    }

    /** @test */
    public function test_render()
    {
        $yaml = new Yaml('test: hi');

        $parsed = $this->yamlRenderer->render($yaml);

        $this->assertEquals(['test' => 'hi'], $parsed);
    }

    /** @test */
    public function test_nested_render()
    {
        $yaml = new Yaml('markdown: markdown.md');

        $parsed = $this->yamlRenderer->render($yaml);

        $this->assertEquals(['markdown' => '<h1>md</h1>' . PHP_EOL], $parsed);
    }
}
