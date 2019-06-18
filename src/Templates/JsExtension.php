<?php

namespace Stitcher\Templates;

use Stitcher\Services\Filesystem;
use Stitcher\Services\JsMinifier;

class JsExtension implements TemplateExtension
{
    private JsMinifier $jsMinifier;

    private Filesystem $filesystem;

    private Filesystem $outputFilesystem;

    private bool $defer = false;

    private bool $async = false;

    private bool $minify = false;

    public function __construct(
        JsMinifier $jsMinifier,
        Filesystem $filesystem,
        Filesystem $outputFilesystem
    ) {
        $this->jsMinifier = $jsMinifier;
        $this->filesystem = $filesystem;
        $this->outputFilesystem = $outputFilesystem;
    }

    public function getName()
    {
        return 'js';
    }

    public function minify(bool $minify = true): JsExtension
    {
        $extension = clone $this;

        $extension->minify = $minify;

        return $extension;
    }

    public function defer(): JsExtension
    {
        $extension = clone $this;

        $extension->defer = true;

        return $extension;
    }

    public function async(): JsExtension
    {
        $extension = clone $this;

        $extension->async = true;

        return $extension;
    }

    public function link(string $src): string
    {
        $content = $this->parse($src);

        $this->outputFilesystem->write($src, $content);

        $script = "<script src=\"{$src}\"";

        if ($this->defer) {
            $script .= ' defer';
        }

        if ($this->async) {
            $script .= ' async';
        }

        $script .= '></script>';

        return $script;
    }

    public function inline(string $src): string
    {
        return '<script>' . $this->parse($src) . '</script>';
    }

    private function parse(string $src): string
    {
        $content = $this->filesystem->read($src);

        if ($this->minify) {
            $content = $this->jsMinifier->minify($content);
        }

        return $content;
    }
}
