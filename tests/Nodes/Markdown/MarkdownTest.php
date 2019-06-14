<?php

namespace Tests\Nodes\Markdown;

use Stitcher\Nodes\Markdown\Markdown;
use Tests\TestCase;

class MarkdownTest extends TestCase
{
    /** @test */
    public function read_from_file()
    {
        $markdown = Markdown::makeFromFile($this->fs->makeFullPath('markdown.md'));

        $this->assertEquals('# md', trim($markdown->markdown));
    }
}
