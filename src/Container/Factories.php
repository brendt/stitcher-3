<?php

namespace Stitcher\Container;

use Stitcher\Nodes\RendererFactory;

/**
 * @mixin \Stitcher\Container\Container
 */
trait Factories
{
    public function rendererFactory(): RendererFactory
    {
        return $this->singleton(
            RendererFactory::class,
            function () {
                return new RendererFactory($this);
            }
        );
    }
}
