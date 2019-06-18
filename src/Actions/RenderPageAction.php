<?php

namespace Stitcher\Actions;

use Stitcher\Nodes\NodeFactory;
use Stitcher\Nodes\Page\PageRenderer;

class RenderPageAction
{
    private NodeFactory $nodeFactory;

    private PageRenderer $pageRenderer;

    public function __construct(
        NodeFactory $nodeFactory,
        PageRenderer $pageRenderer
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->pageRenderer = $pageRenderer;
    }

    public function __invoke(string $url, array $pageConfig): array
    {
        $page = $this->nodeFactory->makePage($url, $pageConfig);

        $htmlFiles = [];

        foreach ($this->pageRenderer->render($page) as $renderedUrl => $html) {
            $htmlFiles[$renderedUrl] = $html;
        }

        return $htmlFiles;
    }
}
