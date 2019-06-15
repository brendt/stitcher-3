<?php

namespace Tests;

use Stitcher\Container\Config;

class TestConfig extends Config
{
    public string $basePath = __DIR__ . '/.data';

    public string $templateDirectory = __DIR__ . '/.data';
}
