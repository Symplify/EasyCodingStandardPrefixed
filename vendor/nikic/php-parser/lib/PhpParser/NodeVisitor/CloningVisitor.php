<?php

declare (strict_types=1);
namespace _PhpScoper0ba97041430d\PhpParser\NodeVisitor;

use _PhpScoper0ba97041430d\PhpParser\Node;
use _PhpScoper0ba97041430d\PhpParser\NodeVisitorAbstract;
/**
 * Visitor cloning all nodes and linking to the original nodes using an attribute.
 *
 * This visitor is required to perform format-preserving pretty prints.
 */
class CloningVisitor extends \_PhpScoper0ba97041430d\PhpParser\NodeVisitorAbstract
{
    public function enterNode(\_PhpScoper0ba97041430d\PhpParser\Node $origNode)
    {
        $node = clone $origNode;
        $node->setAttribute('origNode', $origNode);
        return $node;
    }
}
