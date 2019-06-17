<?php

namespace Stitcher\Modifiers;

use Exception;

class InvalidModifier extends Exception
{
    public static function make(string $modifierName, $expected, $actual = ''): InvalidModifier
    {
        $expectedString = is_array($expected) ?
            json_encode($expected)
            : $expected;

        $actualString = is_array($actual) ?
            json_encode($actual)
            : $actual;

        return new self("Invalid configuration options for `{$modifierName}`, expected `{$expectedString}`, instead got `{$actualString}`");
    }
}
