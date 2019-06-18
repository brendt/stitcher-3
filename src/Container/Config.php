<?php

namespace Stitcher\Container;

class Config
{
    public string $basePath;

    public string $templatePath;

    public string $outputPath;

    public bool $minify_js = false;

    public bool $minify_css = false;
}
