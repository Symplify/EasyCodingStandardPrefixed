<?php

declare (strict_types=1);
namespace _PhpScoperc233426b15e0\PhpParser\NodeVisitor;

use _PhpScoperc233426b15e0\PhpParser\Node;
use _PhpScoperc233426b15e0\PhpParser\NodeVisitorAbstract;
/**
 * Visitor cloning all nodes and linking to the original nodes using an attribute.
 *
 * This visitor is required to perform format-preserving pretty prints.
 */
class CloningVisitor extends \_PhpScoperc233426b15e0\PhpParser\NodeVisitorAbstract
{
    public function enterNode(\_PhpScoperc233426b15e0\PhpParser\Node $origNode)
    {
        $node = clone $origNode;
        $node->setAttribute('origNode', $origNode);
        return $node;
    }
}
