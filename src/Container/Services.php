<?php

namespace Stitcher\Container;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment as CommonMarkEnvironment;
use Stitcher\Actions\RenderAction;
use Stitcher\Actions\RenderPageAction;
use Stitcher\Services\Filesystem;
use Stitcher\Services\JsMinifier;
use Stitcher\Templates\CssExtension;
use Stitcher\Templates\JsExtension;
use Stitcher\Templates\TwigRenderer;
use Symfony\Component\Yaml\Parser;
use tubalmartin\CssMin\Minifier as CssMinifier;
use Twig\Environment as TwigEnvironment;
use Twig\Loader\FilesystemLoader;
use Leafo\ScssPhp\Compiler as SassCompiler;

/**
 * @mixin \Stitcher\Container\Container
 */
trait Services
{
    public function renderAction(): RenderAction
    {
        return new RenderAction(
            $this->filesystem(),
            $this->outputFilesystem(),
            $this->renderPageAction(),
            $this->yamlParser()
        );
    }

    public function renderPageAction(): RenderPageAction
    {
        return new RenderPageAction(
            $this->nodeFactory(),
            $this->pageRenderer()
        );
    }

    public function filesystem(): Filesystem
    {
        return $this->singleton(
            Filesystem::class,
            fn () => new Filesystem($this->config->basePath)
        );
    }

    public function outputFilesystem(): Filesystem
    {
        return $this->singleton(
            Filesystem::class . '-output',
            fn () => new Filesystem($this->config->outputPath)
        );
    }

    public function markdownParser(): CommonMarkConverter
    {
        return $this->singleton(
            CommonMarkConverter::class,
            fn () => new CommonMarkConverter([], CommonMarkEnvironment::createCommonMarkEnvironment())
        );
    }

    public function yamlParser(): Parser
    {
        return $this->singleton(Parser::class, fn () => new Parser());
    }

    public function twigRenderer(): TwigRenderer
    {
        return TwigRenderer::make($this->twigEnvironment())
            ->addExtension($this->jsExtension())
            ->addExtension($this->cssExtension());
    }

    public function twigEnvironment(): TwigEnvironment
    {
        $loader = new FilesystemLoader(
            $this->filesystem()->makeFullPath($this->config->templatePath)
        );

        return new TwigEnvironment($loader);
    }

    public function sassCompiler(): SassCompiler
    {
        return $this->singleton(SassCompiler::class, fn () => new SassCompiler());
    }

    public function cssMinifier(): CssMinifier
    {
        return $this->singleton(CssMinifier::class, fn () => new CssMinifier());
    }

    public function cssExtension(): CssExtension
    {
        return $this->singleton(
            CssExtension::class,
            fn () => (new CssExtension(
                $this->sassCompiler(),
                $this->cssMinifier(),
                $this->filesystem(),
                $this->outputFilesystem()
            ))->minify($this->config->minify_css)
        );
    }

    public function jsMinifier(): JsMinifier
    {
        return $this->singleton(JsMinifier::class, fn () => new JsMinifier());
    }

    public function jsExtension(): JsExtension
    {
        return $this->singleton(
            JsExtension::class,
            fn () => (new JsExtension(
                $this->jsMinifier(),
                $this->filesystem(),
                $this->outputFilesystem())
            )->minify($this->config->minify_js)
        );
    }
}
