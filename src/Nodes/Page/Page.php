<?php

namespace Stitcher\Nodes\Page;

use Stitcher\Node;

class Page implements Node
{
    public string $template;

    public array $variables;

    public static function make(array $config): Page
    {
        return new self(
            $config['template'],
            $config['variables'] ?? []
        );
    }

    public function __construct(
        string $template,
        array $variables
    ) {
        $this->template = $template;
        $this->variables = $variables;
    }
}
