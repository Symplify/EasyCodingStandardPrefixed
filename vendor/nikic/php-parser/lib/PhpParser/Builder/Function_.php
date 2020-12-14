<?php

declare (strict_types=1);
namespace _PhpScoper6224e3b16fcc\PhpParser\Builder;

use _PhpScoper6224e3b16fcc\PhpParser;
use _PhpScoper6224e3b16fcc\PhpParser\BuilderHelpers;
use _PhpScoper6224e3b16fcc\PhpParser\Node;
use _PhpScoper6224e3b16fcc\PhpParser\Node\Stmt;
class Function_ extends \_PhpScoper6224e3b16fcc\PhpParser\Builder\FunctionLike
{
    protected $name;
    protected $stmts = [];
    /**
     * Creates a function builder.
     *
     * @param string $name Name of the function
     */
    public function __construct(string $name)
    {
        $this->name = $name;
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
        $this->stmts[] = \_PhpScoper6224e3b16fcc\PhpParser\BuilderHelpers::normalizeStmt($stmt);
        return $this;
    }
    /**
     * Returns the built function node.
     *
     * @return Stmt\Function_ The built function node
     */
    public function getNode() : \_PhpScoper6224e3b16fcc\PhpParser\Node
    {
        return new \_PhpScoper6224e3b16fcc\PhpParser\Node\Stmt\Function_($this->name, ['byRef' => $this->returnByRef, 'params' => $this->params, 'returnType' => $this->returnType, 'stmts' => $this->stmts], $this->attributes);
    }
}
