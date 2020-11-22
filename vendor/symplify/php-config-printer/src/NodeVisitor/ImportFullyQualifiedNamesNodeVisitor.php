<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeVisitor;

use _PhpScoper3fa05b4669af\Nette\Utils\Strings;
use _PhpScoper3fa05b4669af\PhpParser\Node;
use _PhpScoper3fa05b4669af\PhpParser\Node\Name;
use _PhpScoper3fa05b4669af\PhpParser\Node\Name\FullyQualified;
use _PhpScoper3fa05b4669af\PhpParser\NodeVisitorAbstract;
use Symplify\PhpConfigPrinter\Naming\ClassNaming;
final class ImportFullyQualifiedNamesNodeVisitor extends \_PhpScoper3fa05b4669af\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\_PhpScoper3fa05b4669af\PhpParser\Node $node) : ?\_PhpScoper3fa05b4669af\PhpParser\Node
    {
        if (!$node instanceof \_PhpScoper3fa05b4669af\PhpParser\Node\Name\FullyQualified) {
            return null;
        }
        $fullyQualifiedName = $node->toString();
        // namespace-less class name
        if (\_PhpScoper3fa05b4669af\Nette\Utils\Strings::startsWith($fullyQualifiedName, '\\')) {
            $fullyQualifiedName = \ltrim($fullyQualifiedName, '\\');
        }
        if (!\_PhpScoper3fa05b4669af\Nette\Utils\Strings::contains($fullyQualifiedName, '\\')) {
            return new \_PhpScoper3fa05b4669af\PhpParser\Node\Name($fullyQualifiedName);
        }
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);
        $this->nameImports[] = $fullyQualifiedName;
        return new \_PhpScoper3fa05b4669af\PhpParser\Node\Name($shortClassName);
    }
    /**
     * @return string[]
     */
    public function getNameImports() : array
    {
        return $this->nameImports;
    }
}
