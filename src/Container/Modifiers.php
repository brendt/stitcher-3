<?php

namespace Stitcher\Container;

use Stitcher\Modifiers\CollectionModifier;

/**
 * @mixin \Stitcher\Container\Container
 */
trait Modifiers
{
    public function collectionModifier(
        string $variableName,
        string $field
    ): CollectionModifier {
        return new CollectionModifier(
            $variableName,
            $field,
            $this->nodeFactory(),
            $this->rendererFactory(),
            $this->filesystem(),
        );
    }
}
