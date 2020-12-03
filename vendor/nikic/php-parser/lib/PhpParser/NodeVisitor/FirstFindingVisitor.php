<?php

declare (strict_types=1);
namespace _PhpScoperba5852cc6147\PhpParser\NodeVisitor;

use _PhpScoperba5852cc6147\PhpParser\Node;
use _PhpScoperba5852cc6147\PhpParser\NodeTraverser;
use _PhpScoperba5852cc6147\PhpParser\NodeVisitorAbstract;
/**
 * This visitor can be used to find the first node satisfying some criterion determined by
 * a filter callback.
 */
class FirstFindingVisitor extends \_PhpScoperba5852cc6147\PhpParser\NodeVisitorAbstract
{
    /** @var callable Filter callback */
    protected $filterCallback;
    /** @var null|Node Found node */
    protected $foundNode;
    public function __construct(callable $filterCallback)
    {
        $this->filterCallback = $filterCallback;
    }
    /**
     * Get found node satisfying the filter callback.
     *
     * Returns null if no node satisfies the filter callback.
     *
     * @return null|Node Found node (or null if not found)
     */
    public function getFoundNode()
    {
        return $this->foundNode;
    }
    public function beforeTraverse(array $nodes)
    {
        $this->foundNode = null;
        return null;
    }
    public function enterNode(\_PhpScoperba5852cc6147\PhpParser\Node $node)
    {
        $filterCallback = $this->filterCallback;
        if ($filterCallback($node)) {
            $this->foundNode = $node;
            return \_PhpScoperba5852cc6147\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        }
        return null;
    }
}
