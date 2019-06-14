<?php

namespace Tests;

use Stitcher\Container\Container;
use Stitcher\Services\Filesystem;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var Container */
    protected Container $container;

    /** @var Filesystem */
    protected Filesystem $fs;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new Container(new TestConfig());

        $this->fs = $this->container->filesystem();

        $this->fs
            ->withBase(__DIR__)
            ->remove('./.data')
            ->copy(
                './.stubs',
                './.data'
            );
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->fs
            ->withBase(__DIR__)
            ->remove('./.data');
    }
}
