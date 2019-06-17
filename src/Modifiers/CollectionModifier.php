<?php

namespace Stitcher\Modifiers;

use Stitcher\Exceptions\InvalidNode;
use Stitcher\Nodes\NodeCollection;
use Stitcher\Nodes\NodeFactory;
use Stitcher\Nodes\Page\Page;
use Stitcher\Nodes\RendererFactory;
use Stitcher\Services\Filesystem;

class CollectionModifier implements Modifier
{
    private string $variableName;

    private string $field;

    private NodeFactory $nodeFactory;

    private RendererFactory $rendererFactory;

    private Filesystem $filesystem;

    public function __construct(
        string $variableName,
        string $field,
        NodeFactory $nodeFactory,
        RendererFactory $rendererFactory,
        Filesystem $filesystem
    ) {
        $this->variableName = $variableName;
        $this->field = $field;
        $this->nodeFactory = $nodeFactory;
        $this->rendererFactory = $rendererFactory;
        $this->filesystem = $filesystem;
    }

    public function getName(): string
    {
        return 'collection';
    }

    public function modify(NodeCollection $pages): NodeCollection
    {
        $modifiedPages = new NodeCollection();

        foreach ($pages as $url => $page) {
            if (! $page instanceof Page) {
                throw InvalidNode::node($page, Page::class);
            }

            $renderedVariable = $this->renderPageVariable($page);

            foreach ($renderedVariable as $id => $data) {
                $data['id'] = $data['id'] ?? $id;

                $pageUrl = str_replace('{' . $this->variableName . '}', $id,$page->url);

                $modifiedPages[$pageUrl] = $page
                    ->withUrl($pageUrl)
                    ->withVariable($this->variableName, $data);
            }
        }

        return $modifiedPages;
    }

    private function renderPageVariable(Page $page)
    {
        $variableNode = $this->nodeFactory
            ->make(
                $this->filesystem->makeFullPath($page->variables[$this->variableName])
            );

        $renderedVariable = $this->rendererFactory
            ->make($variableNode)
            ->render($variableNode);

        return $renderedVariable;
    }
}
