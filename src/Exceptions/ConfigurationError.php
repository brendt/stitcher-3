<?php

namespace Stitcher\Exceptions;

use Exception;

class ConfigurationError extends Exception
{
    public static function unknownNode(string $value): ConfigurationError
    {
        return new self("Unable to make a valid node from {$value}");
    }
}
