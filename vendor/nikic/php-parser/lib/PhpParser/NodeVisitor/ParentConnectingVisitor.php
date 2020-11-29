<?php

declare (strict_types=1);
namespace _PhpScoper9d73a84b09ad\PhpParser\NodeVisitor;

use function array_pop;
use function count;
use _PhpScoper9d73a84b09ad\PhpParser\Node;
use _PhpScoper9d73a84b09ad\PhpParser\NodeVisitorAbstract;
/**
 * Visitor that connects a child node to its parent node.
 *
 * On the child node, the parent node can be accessed through
 * <code>$node->getAttribute('parent')</code>.
 */
final class ParentConnectingVisitor extends \_PhpScoper9d73a84b09ad\PhpParser\NodeVisitorAbstract
{
    /**
     * @var Node[]
     */
    private $stack = [];
    public function beforeTraverse(array $nodes)
    {
        $this->stack = [];
    }
    public function enterNode(\_PhpScoper9d73a84b09ad\PhpParser\Node $node)
    {
        if (!empty($this->stack)) {
            $node->setAttribute('parent', $this->stack[\count($this->stack) - 1]);
        }
        $this->stack[] = $node;
    }
    public function leaveNode(\_PhpScoper9d73a84b09ad\PhpParser\Node $node)
    {
        \array_pop($this->stack);
    }
}
