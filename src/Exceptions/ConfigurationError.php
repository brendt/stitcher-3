<?php

namespace Stitcher\Exceptions;

use Exception;

class ConfigurationError extends Exception
{
    public static function unknownNode($value): ConfigurationError
    {
        if (is_array($value)) {
            $value = json_encode($value);
        } elseif (is_object($value)) {
            $value = (string) $value;
        }

        return new self("Unable to make a valid node from {$value}");
    }
}
