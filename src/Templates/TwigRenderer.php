<?php

namespace Stitcher\Templates;

use Twig\Environment as TwigEnvironment;

class TwigRenderer
{
    private TwigEnvironment $twig;

    public static function make(TwigEnvironment $twig): TwigRenderer
    {
        return new self($twig);
    }

    public function __construct(TwigEnvironment $twig) {
        $this->twig = $twig;
    }

    public function addExtension(TemplateExtension $extension): TwigRenderer
    {
        $this->twig->addGlobal($extension->getName(), $extension);

        return $this;
    }

    public function render(string $template, array $variables = []): string
    {
        return $this->twig->render($template, $variables);
    }
}
