<?php

namespace Stitcher\Container;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use Stitcher\Services\Filesystem;

/**
 * @mixin \Stitcher\Container\Container
 */
trait Services
{
    public function filesystem(): Filesystem
    {
        return $this->singleton(Filesystem::class, function () {
            return new Filesystem($this->config->basePath);
        });
    }

    public function commonMarkEnvironment(): Environment
    {
        return $this->singleton(Environment::class, function () {
            return Environment::createCommonMarkEnvironment();
        });
    }

    public function markdownConverter(): CommonMarkConverter
    {
        return $this->singleton(CommonMarkConverter::class, function () {
            return new CommonMarkConverter([], $this->commonMarkEnvironment());
        });
    }
}
