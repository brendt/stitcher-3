<?php

namespace Stitcher\Modifiers;

use Stitcher\Container\Container;

class ModifierFactory
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function make(string $modifierName, $config): Modifier
    {
        if ($modifierName === 'collection') {
            if (
                ! is_array($config)
                || ! isset($config['variable'], $config['field'])
            ) {
                throw InvalidModifier::make($modifierName, ['variable', 'field'], $config);
            }

            return $this->container->collectionModifier(
                $config['variable'],
                $config['field']
            );
        }
    }
}
