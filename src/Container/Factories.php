<?php

namespace Stitcher\Container;

use Stitcher\Modifiers\ModifierFactory;
use Stitcher\Nodes\NodeFactory;
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
            fn () => new RendererFactory($this)
        );
    }

    public function nodeFactory(): NodeFactory
    {
        return $this->singleton(
            NodeFactory::class,
            fn () => new NodeFactory($this->filesystem())
        );
    }

    public function modifierFactory(): ModifierFactory
    {
        return $this->singleton(
            ModifierFactory::class,
            fn () => new ModifierFactory($this)
        );
    }
}
