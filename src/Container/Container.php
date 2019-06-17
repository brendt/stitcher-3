<?php

namespace Stitcher\Container;

use Closure;

class Container
{
    protected Config $config;

    private static array $singletons = [];

    use Factories,
        Modifiers,
        Renderers,
        Services;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    private function singleton(string $class, Closure $closure)
    {
        if (! isset(self::$singletons[$class])) {
            self::$singletons[$class] = $closure();
        }

        return self::$singletons[$class];
    }
}
