<?php

namespace Stitcher\Services;

class Str
{
    public static function startsWith(string $needle, string $haystack): bool
    {
        return strpos($haystack, $needle) === 0;
    }

    /**
     * @param string|array $needles
     * @param string $haystack
     *
     * @return bool
     */
    public static function endsWith($needles, string $haystack): bool
    {
        $needles = (array) $needles;

        foreach ($needles as $needle) {
            $length = strlen($needle);

            if (substr($haystack, -$length) === $needle) {
                return true;
            }
        }

        return false;
    }
}
