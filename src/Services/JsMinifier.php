<?php

namespace Stitcher\Services;

use JSMin\JSMin;

class JsMinifier
{
    public function minify(string $javascript): string
    {
        return JSMin::minify($javascript);
    }
}
