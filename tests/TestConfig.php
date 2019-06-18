<?php

namespace Tests;

use Stitcher\Container\Config;

class TestConfig extends Config
{
    public string $basePath = __DIR__ . '/.data';

    public string $templatePath = __DIR__ . '/.data';

    public string $outputPath = __DIR__ . '/.data/output';
}
