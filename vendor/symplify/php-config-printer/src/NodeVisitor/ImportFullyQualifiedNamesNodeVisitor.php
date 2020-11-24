<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeVisitor;

use _PhpScoper7c0f822a05e1\Nette\Utils\Strings;
use _PhpScoper7c0f822a05e1\PhpParser\Node;
use _PhpScoper7c0f822a05e1\PhpParser\Node\Name;
use _PhpScoper7c0f822a05e1\PhpParser\Node\Name\FullyQualified;
use _PhpScoper7c0f822a05e1\PhpParser\NodeVisitorAbstract;
use Symplify\PhpConfigPrinter\Naming\ClassNaming;
final class ImportFullyQualifiedNamesNodeVisitor extends \_PhpScoper7c0f822a05e1\PhpParser\NodeVisitorAbstract
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var string[]
     */
    private $nameImports = [];
    public function __construct(\Symplify\PhpConfigPrinter\Naming\ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }
    /**
     * @param Node[] $nodes
     * @return Node[]|null
     */
    public function beforeTraverse(array $nodes) : ?array
    {
        $this->nameImports = [];
        return null;
    }
    public function enterNode(\_PhpScoper7c0f822a05e1\PhpParser\Node $node) : ?\_PhpScoper7c0f822a05e1\PhpParser\Node
    {
        if (!$node instanceof \_PhpScoper7c0f822a05e1\PhpParser\Node\Name\FullyQualified) {
            return null;
        }
        $fullyQualifiedName = $node->toString();
        // namespace-less class name
        if (\_PhpScoper7c0f822a05e1\Nette\Utils\Strings::startsWith($fullyQualifiedName, '\\')) {
            $fullyQualifiedName = \ltrim($fullyQualifiedName, '\\');
        }
        if (!\_PhpScoper7c0f822a05e1\Nette\Utils\Strings::contains($fullyQualifiedName, '\\')) {
            return new \_PhpScoper7c0f822a05e1\PhpParser\Node\Name($fullyQualifiedName);
        }
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);
        $this->nameImports[] = $fullyQualifiedName;
        return new \_PhpScoper7c0f822a05e1\PhpParser\Node\Name($shortClassName);
    }
    /**
     * @return string[]
     */
    public function getNameImports() : array
    {
        return $this->nameImports;
    }
}
