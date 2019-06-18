<?php

namespace Stitcher\Actions;

use Stitcher\Services\Filesystem;
use Symfony\Component\Yaml\Parser as YamlParser;

class RenderAction
{
    private Filesystem $filesystem;

    private Filesystem $outputFilesystem;

    private RenderPageAction $renderPageAction;

    private YamlParser $yamlParser;

    public function __construct(
        Filesystem $filesystem,
        Filesystem $outputFilesystem,
        RenderPageAction $renderPageAction,
        YamlParser $yamlParser
    ) {
        $this->filesystem = $filesystem;

        $this->outputFilesystem = $outputFilesystem;

        $this->renderPageAction = $renderPageAction;

        $this->yamlParser = $yamlParser;
    }

    public function __invoke(string $path): void
    {
        $siteConfig = $this->yamlParser->parseFile(
            $this->filesystem->makeFullPath($path)
        );

        $htmlFiles = [];

        foreach ($siteConfig as $url => $pageConfig) {
            $htmlFiles = array_merge(
                $htmlFiles,
                ($this->renderPageAction)($url, $pageConfig)
            );
        }

        foreach ($htmlFiles as $url => $htmlFile) {
            $this->outputFilesystem->write(
                $url . '.html',
                $htmlFile
            );
        }
    }
}
