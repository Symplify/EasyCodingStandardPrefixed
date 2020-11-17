<?php

declare (strict_types=1);
namespace _PhpScoper967c4b7e296e\PhpParser\NodeVisitor;

use _PhpScoper967c4b7e296e\PhpParser\ErrorHandler;
use _PhpScoper967c4b7e296e\PhpParser\NameContext;
use _PhpScoper967c4b7e296e\PhpParser\Node;
use _PhpScoper967c4b7e296e\PhpParser\Node\Expr;
use _PhpScoper967c4b7e296e\PhpParser\Node\Name;
use _PhpScoper967c4b7e296e\PhpParser\Node\Name\FullyQualified;
use _PhpScoper967c4b7e296e\PhpParser\Node\Stmt;
use _PhpScoper967c4b7e296e\PhpParser\NodeVisitorAbstract;
class NameResolver extends \_PhpScoper967c4b7e296e\PhpParser\NodeVisitorAbstract
{
    /** @var NameContext Naming context */
    protected $nameContext;
    /** @var bool Whether to preserve original names */
    protected $preserveOriginalNames;
    /** @var bool Whether to replace resolved nodes in place, or to add resolvedNode attributes */
    protected $replaceNodes;
    /**
     * Constructs a name resolution visitor.
     *
     * Options:
     *  * preserveOriginalNames (default false): An "originalName" attribute will be added to
     *    all name nodes that underwent resolution.
     *  * replaceNodes (default true): Resolved names are replaced in-place. Otherwise, a
     *    resolvedName attribute is added. (Names that cannot be statically resolved receive a
     *    namespacedName attribute, as usual.)
     *
     * @param ErrorHandler|null $errorHandler Error handler
     * @param array $options Options
     */
    public function __construct(\_PhpScoper967c4b7e296e\PhpParser\ErrorHandler $errorHandler = null, array $options = [])
    {
        $this->nameContext = new \_PhpScoper967c4b7e296e\PhpParser\NameContext($errorHandler ?? new \_PhpScoper967c4b7e296e\PhpParser\ErrorHandler\Throwing());
        $this->preserveOriginalNames = $options['preserveOriginalNames'] ?? \false;
        $this->replaceNodes = $options['replaceNodes'] ?? \true;
    }
    /**
     * Get name resolution context.
     *
     * @return NameContext
     */
    public function getNameContext() : \_PhpScoper967c4b7e296e\PhpParser\NameContext
    {
        return $this->nameContext;
    }
    public function beforeTraverse(array $nodes)
    {
        $this->nameContext->startNamespace();
        return null;
    }
    public function enterNode(\_PhpScoper967c4b7e296e\PhpParser\Node $node)
    {
        if ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Namespace_) {
            $this->nameContext->startNamespace($node->name);
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Use_) {
            foreach ($node->uses as $use) {
                $this->addAlias($use, $node->type, null);
            }
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\GroupUse) {
            foreach ($node->uses as $use) {
                $this->addAlias($use, $node->type, $node->prefix);
            }
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Class_) {
            if (null !== $node->extends) {
                $node->extends = $this->resolveClassName($node->extends);
            }
            foreach ($node->implements as &$interface) {
                $interface = $this->resolveClassName($interface);
            }
            if (null !== $node->name) {
                $this->addNamespacedName($node);
            }
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Interface_) {
            foreach ($node->extends as &$interface) {
                $interface = $this->resolveClassName($interface);
            }
            $this->addNamespacedName($node);
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Trait_) {
            $this->addNamespacedName($node);
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Function_) {
            $this->addNamespacedName($node);
            $this->resolveSignature($node);
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\ClassMethod || $node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Expr\Closure || $node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Expr\ArrowFunction) {
            $this->resolveSignature($node);
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Property) {
            if (null !== $node->type) {
                $node->type = $this->resolveType($node->type);
            }
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Const_) {
            foreach ($node->consts as $const) {
                $this->addNamespacedName($const);
            }
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Expr\StaticCall || $node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Expr\StaticPropertyFetch || $node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Expr\ClassConstFetch || $node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Expr\New_ || $node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Expr\Instanceof_) {
            if ($node->class instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Name) {
                $node->class = $this->resolveClassName($node->class);
            }
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Catch_) {
            foreach ($node->types as &$type) {
                $type = $this->resolveClassName($type);
            }
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Expr\FuncCall) {
            if ($node->name instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Name) {
                $node->name = $this->resolveName($node->name, \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION);
            }
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Expr\ConstFetch) {
            $node->name = $this->resolveName($node->name, \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Use_::TYPE_CONSTANT);
        } elseif ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\TraitUse) {
            foreach ($node->traits as &$trait) {
                $trait = $this->resolveClassName($trait);
            }
            foreach ($node->adaptations as $adaptation) {
                if (null !== $adaptation->trait) {
                    $adaptation->trait = $this->resolveClassName($adaptation->trait);
                }
                if ($adaptation instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\TraitUseAdaptation\Precedence) {
                    foreach ($adaptation->insteadof as &$insteadof) {
                        $insteadof = $this->resolveClassName($insteadof);
                    }
                }
            }
        }
        return null;
    }
    private function addAlias(\_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\UseUse $use, $type, \_PhpScoper967c4b7e296e\PhpParser\Node\Name $prefix = null)
    {
        // Add prefix for group uses
        $name = $prefix ? \_PhpScoper967c4b7e296e\PhpParser\Node\Name::concat($prefix, $use->name) : $use->name;
        // Type is determined either by individual element or whole use declaration
        $type |= $use->type;
        $this->nameContext->addAlias($name, (string) $use->getAlias(), $type, $use->getAttributes());
    }
    /** @param Stmt\Function_|Stmt\ClassMethod|Expr\Closure $node */
    private function resolveSignature($node)
    {
        foreach ($node->params as $param) {
            $param->type = $this->resolveType($param->type);
        }
        $node->returnType = $this->resolveType($node->returnType);
    }
    private function resolveType($node)
    {
        if ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\Name) {
            return $this->resolveClassName($node);
        }
        if ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\NullableType) {
            $node->type = $this->resolveType($node->type);
            return $node;
        }
        if ($node instanceof \_PhpScoper967c4b7e296e\PhpParser\Node\UnionType) {
            foreach ($node->types as &$type) {
                $type = $this->resolveType($type);
            }
            return $node;
        }
        return $node;
    }
    /**
     * Resolve name, according to name resolver options.
     *
     * @param Name $name Function or constant name to resolve
     * @param int  $type One of Stmt\Use_::TYPE_*
     *
     * @return Name Resolved name, or original name with attribute
     */
    protected function resolveName(\_PhpScoper967c4b7e296e\PhpParser\Node\Name $name, int $type) : \_PhpScoper967c4b7e296e\PhpParser\Node\Name
    {
        if (!$this->replaceNodes) {
            $resolvedName = $this->nameContext->getResolvedName($name, $type);
            if (null !== $resolvedName) {
                $name->setAttribute('resolvedName', $resolvedName);
            } else {
                $name->setAttribute('namespacedName', \_PhpScoper967c4b7e296e\PhpParser\Node\Name\FullyQualified::concat($this->nameContext->getNamespace(), $name, $name->getAttributes()));
            }
            return $name;
        }
        if ($this->preserveOriginalNames) {
            // Save the original name
            $originalName = $name;
            $name = clone $originalName;
            $name->setAttribute('originalName', $originalName);
        }
        $resolvedName = $this->nameContext->getResolvedName($name, $type);
        if (null !== $resolvedName) {
            return $resolvedName;
        }
        // unqualified names inside a namespace cannot be resolved at compile-time
        // add the namespaced version of the name as an attribute
        $name->setAttribute('namespacedName', \_PhpScoper967c4b7e296e\PhpParser\Node\Name\FullyQualified::concat($this->nameContext->getNamespace(), $name, $name->getAttributes()));
        return $name;
    }
    protected function resolveClassName(\_PhpScoper967c4b7e296e\PhpParser\Node\Name $name)
    {
        return $this->resolveName($name, \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\Use_::TYPE_NORMAL);
    }
    protected function addNamespacedName(\_PhpScoper967c4b7e296e\PhpParser\Node $node)
    {
        $node->namespacedName = \_PhpScoper967c4b7e296e\PhpParser\Node\Name::concat($this->nameContext->getNamespace(), (string) $node->name);
    }
}
