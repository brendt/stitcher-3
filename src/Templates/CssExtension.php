<?php

namespace Stitcher\Templates;

use Leafo\ScssPhp\Compiler as SassCompiler;
use Stitcher\Html\Source;
use Stitcher\Services\Filesystem;
use tubalmartin\CssMin\Minifier as CssMinifier;
use function in_array;

class CssExtension
{
    private SassCompiler $sassCompiler;

    private CssMinifier $cssMinifier;

    private Filesystem $filesystem;

    private Filesystem $outputFilesystem;

    private bool $minify = false;

    public function __construct(
        SassCompiler $sassCompiler,
        CssMinifier $cssMinifier,
        Filesystem $filesystem,
        Filesystem $outputFilesystem
    ) {
        $this->sassCompiler = $sassCompiler;
        $this->cssMinifier = $cssMinifier;
        $this->filesystem = $filesystem;
        $this->outputFilesystem = $outputFilesystem;
    }

    public function minify(bool $minify = true): self
    {
        $this->minify = $minify;

        return $this;
    }

    public function link(string $src): string
    {
        $src = ltrim($src, '/');

        ['dirname' => $dirname, 'filename' => $filename] = pathinfo($src);

        $css = $this->parse($src);

        $path = "{$dirname}/{$filename}.css";

        $this->outputFilesystem->write($path, $css);

        return "<link rel=\"stylesheet\" href=\"/{$path}\" />";
    }

    public function inline(string $src): string
    {
        return '<style>' . $this->parse($src) . '</style>';
    }

    private function parse(string $src): string
    {
        ['extension' => $extension] = pathinfo($src);

        $content = $this->filesystem->read($src);

        if (in_array($extension, ['scss', 'sass'])) {
            $content = $this->sassCompiler->compile($content);
        }

        if ($this->minify) {
            $content = $this->cssMinifier->run($content);
        }

        return $content;
    }
}
