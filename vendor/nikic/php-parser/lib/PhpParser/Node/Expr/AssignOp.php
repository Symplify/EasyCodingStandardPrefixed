<?php

declare (strict_types=1);
namespace _PhpScoper745103eaabcd\PhpParser\Node\Expr;

use _PhpScoper745103eaabcd\PhpParser\Node\Expr;
abstract class AssignOp extends \_PhpScoper745103eaabcd\PhpParser\Node\Expr
{
    /** @var Expr Variable */
    public $var;
    /** @var Expr Expression */
    public $expr;
    /**
     * Constructs a compound assignment operation node.
     *
     * @param Expr  $var        Variable
     * @param Expr  $expr       Expression
     * @param array $attributes Additional attributes
     */
    public function __construct(\_PhpScoper745103eaabcd\PhpParser\Node\Expr $var, \_PhpScoper745103eaabcd\PhpParser\Node\Expr $expr, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->var = $var;
        $this->expr = $expr;
    }
    public function getSubNodeNames() : array
    {
        return ['var', 'expr'];
    }
}
