<?php

namespace Stitcher\Nodes\Page;

use Stitcher\Modifiers\Modifier;
use Stitcher\Node;

class Page implements Node
{
    public string $url;

    public string $template;

    public array $variables;

    public array $modifiers;

    public static function make(array $config): Page
    {
        return new self(
            $config['template'],
            $config['variables'] ?? [],
            $config['modifiers'] ?? []
        );
    }

    public function __construct(
        string $url,
        string $template,
        array $variables = [],
        array $modifiers = []
    ) {
        $this->url = $url;
        $this->template = $template;
        $this->variables = $variables;
        $this->modifiers = $modifiers;
    }

    public function withUrl(string $id): Page
    {
        $page = clone $this;

        $page->url = $id;

        return $page;
    }

    public function withVariables(array $variables): Page
    {
        $page = clone $this;

        $page->variables = $variables;

        return $page;
    }

    public function withVariable(string $name, $value): Page
    {
        $page = clone $this;

        $page->variables[$name] = $value;

        return $page;
    }

    public function withoutModifier(Modifier $modifier): Page
    {
        $page = clone $this;

        unset($page->modifiers[$modifier->getName()]);

        return $page;
    }
}
