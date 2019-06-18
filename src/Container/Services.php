<?php

namespace Stitcher\Container;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment as CommonMarkEnvironment;
use Stitcher\Actions\RenderAction;
use Stitcher\Actions\RenderPageAction;
use Stitcher\Services\Filesystem;
use Symfony\Component\Yaml\Parser;
use Twig\Environment as TwigEnvironment;
use Twig\Loader\FilesystemLoader;

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
        return $this->singleton(Filesystem::class, function () {
            return new Filesystem($this->config->basePath);
        });
    }

    public function outputFilesystem(): Filesystem
    {
        return $this->singleton(Filesystem::class . '-output', function () {
            return new Filesystem($this->config->outputPath);
        });
    }

    public function markdownParser(): CommonMarkConverter
    {
        return $this->singleton(CommonMarkConverter::class, function () {
            return new CommonMarkConverter([], CommonMarkEnvironment::createCommonMarkEnvironment());
        });
    }

    public function yamlParser(): Parser
    {
        return $this->singleton(Parser::class, function () {
            return new Parser();
        });
    }

    public function twigParser(): TwigEnvironment
    {
        return $this->singleton(TwigEnvironment::class, function () {
            $loader = new FilesystemLoader(
                $this->filesystem()->makeFullPath($this->config->templatePath)
            );

            return new TwigEnvironment($loader);
        });
    }
}
