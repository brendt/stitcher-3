<?php

namespace Tests\Nodes\Yaml;

use Stitcher\Nodes\Yaml\Yaml;
use Tests\TestCase;

class YamlTest extends TestCase
{
    /** @test */
    public function read_from_file()
    {
        $yaml = Yaml::make($this->fs->makeFullPath('site.yaml'));

        $this->assertStringContainsString('test:', trim($yaml->yaml));
    }
}
