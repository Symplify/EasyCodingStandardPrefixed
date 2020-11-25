<?php

declare (strict_types=1);
namespace _PhpScoper13133e188f67\PhpParser\Builder;

use _PhpScoper13133e188f67\PhpParser;
use _PhpScoper13133e188f67\PhpParser\BuilderHelpers;
use _PhpScoper13133e188f67\PhpParser\Node;
use _PhpScoper13133e188f67\PhpParser\Node\Stmt;
class Method extends \_PhpScoper13133e188f67\PhpParser\Builder\FunctionLike
{
    protected $name;
    protected $flags = 0;
    /** @var array|null */
    protected $stmts = [];
    /**
     * Creates a method builder.
     *
     * @param string $name Name of the method
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    /**
     * Makes the method public.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePublic()
    {
        $this->flags = \_PhpScoper13133e188f67\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScoper13133e188f67\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC);
        return $this;
    }
    /**
     * Makes the method protected.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeProtected()
    {
        $this->flags = \_PhpScoper13133e188f67\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScoper13133e188f67\PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED);
        return $this;
    }
    /**
     * Makes the method private.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePrivate()
    {
        $this->flags = \_PhpScoper13133e188f67\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScoper13133e188f67\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
        return $this;
    }
    /**
     * Makes the method static.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeStatic()
    {
        $this->flags = \_PhpScoper13133e188f67\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScoper13133e188f67\PhpParser\Node\Stmt\Class_::MODIFIER_STATIC);
        return $this;
    }
    /**
     * Makes the method abstract.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeAbstract()
    {
        if (!empty($this->stmts)) {
            throw new \LogicException('Cannot make method with statements abstract');
        }
        $this->flags = \_PhpScoper13133e188f67\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScoper13133e188f67\PhpParser\Node\Stmt\Class_::MODIFIER_ABSTRACT);
        $this->stmts = null;
        // abstract methods don't have statements
        return $this;
    }
    /**
     * Makes the method final.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeFinal()
    {
        $this->flags = \_PhpScoper13133e188f67\PhpParser\BuilderHelpers::addModifier($this->flags, \_PhpScoper13133e188f67\PhpParser\Node\Stmt\Class_::MODIFIER_FINAL);
        return $this;
    }
    /**
     * Adds a statement.
     *
     * @param Node|PhpParser\Builder $stmt The statement to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmt($stmt)
    {
        if (null === $this->stmts) {
            throw new \LogicException('Cannot add statements to an abstract method');
        }
        $this->stmts[] = \_PhpScoper13133e188f67\PhpParser\BuilderHelpers::normalizeStmt($stmt);
        return $this;
    }
    /**
     * Returns the built method node.
     *
     * @return Stmt\ClassMethod The built method node
     */
    public function getNode() : \_PhpScoper13133e188f67\PhpParser\Node
    {
        return new \_PhpScoper13133e188f67\PhpParser\Node\Stmt\ClassMethod($this->name, ['flags' => $this->flags, 'byRef' => $this->returnByRef, 'params' => $this->params, 'returnType' => $this->returnType, 'stmts' => $this->stmts], $this->attributes);
    }
}
