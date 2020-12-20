<?php

declare (strict_types=1);
namespace _PhpScopere205696a9dd6\PhpParser\Builder;

use _PhpScopere205696a9dd6\PhpParser;
use _PhpScopere205696a9dd6\PhpParser\BuilderHelpers;
use _PhpScopere205696a9dd6\PhpParser\Node\Name;
use _PhpScopere205696a9dd6\PhpParser\Node\Stmt;
class Class_ extends \_PhpScopere205696a9dd6\PhpParser\Builder\Declaration
{
    protected $name;
    protected $extends = null;
    protected $implements = [];
    protected $flags = 0;
    protected $uses = [];
    protected $constants = [];
    protected $properties = [];
    protected $methods = [];
    /**
     * Creates a class builder.
     *
     * @param string $name Name of the class
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    /**
     * Extends a class.
     *
     * @param Name|string $class Name of class to extend
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function extend($class)
    {
        $this->extends = \_PhpScopere205696a9dd6\PhpParser\BuilderHelpers::normalizeName($class);
        return $this;
    }
    /**
     * Implements one or more interfaces.
     *
     * @param Name|string ...$interfaces Names of interfaces to implement
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function implement(...$interfaces)
    {
        foreach ($interfaces as $interface) {
            $this->implements[] = \_PhpScopere205696a9dd6\PhpParser\BuilderHelpers::normalizeName($interface);
        }
        return $this;
    }
    /**
     * Makes the class abstract.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeAbstract()
    {
        $this->flags = \_PhpScopere205696a9dd6\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScopere205696a9dd6\PhpParser\Node\Stmt\Class_::MODIFIER_ABSTRACT);
        return $this;
    }
    /**
     * Makes the class final.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeFinal()
    {
        $this->flags = \_PhpScopere205696a9dd6\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScopere205696a9dd6\PhpParser\Node\Stmt\Class_::MODIFIER_FINAL);
        return $this;
    }
    /**
     * Adds a statement.
     *
     * @param Stmt|PhpParser\Builder $stmt The statement to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmt($stmt)
    {
        $stmt = \_PhpScopere205696a9dd6\PhpParser\BuilderHelpers::normalizeNode($stmt);
        $targets = [\_PhpScopere205696a9dd6\PhpParser\Node\Stmt\TraitUse::class => &$this->uses, \_PhpScopere205696a9dd6\PhpParser\Node\Stmt\ClassConst::class => &$this->constants, \_PhpScopere205696a9dd6\PhpParser\Node\Stmt\Property::class => &$this->properties, \_PhpScopere205696a9dd6\PhpParser\Node\Stmt\ClassMethod::class => &$this->methods];
        $class = \get_class($stmt);
        if (!isset($targets[$class])) {
            throw new \LogicException(\sprintf('Unexpected node of type "%s"', $stmt->getType()));
        }
        $targets[$class][] = $stmt;
        return $this;
    }
    /**
     * Returns the built class node.
     *
     * @return Stmt\Class_ The built class node
     */
    public function getNode() : \_PhpScopere205696a9dd6\PhpParser\Node
    {
        return new \_PhpScopere205696a9dd6\PhpParser\Node\Stmt\Class_($this->name, ['flags' => $this->flags, 'extends' => $this->extends, 'implements' => $this->implements, 'stmts' => \array_merge($this->uses, $this->constants, $this->properties, $this->methods)], $this->attributes);
    }
}
