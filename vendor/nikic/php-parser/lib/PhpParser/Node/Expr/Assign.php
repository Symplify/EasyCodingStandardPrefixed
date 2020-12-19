<?php

declare (strict_types=1);
namespace _PhpScoper8b97b0dd6f5b\PhpParser\Node\Expr;

use _PhpScoper8b97b0dd6f5b\PhpParser\Node\Expr;
class Assign extends \_PhpScoper8b97b0dd6f5b\PhpParser\Node\Expr
{
    /** @var Expr Variable */
    public $var;
    /** @var Expr Expression */
    public $expr;
    /**
     * Constructs an assignment node.
     *
     * @param Expr  $var        Variable
     * @param Expr  $expr       Expression
     * @param array $attributes Additional attributes
     */
    public function __construct(\_PhpScoper8b97b0dd6f5b\PhpParser\Node\Expr $var, \_PhpScoper8b97b0dd6f5b\PhpParser\Node\Expr $expr, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->var = $var;
        $this->expr = $expr;
    }
    public function getSubNodeNames() : array
    {
        return ['var', 'expr'];
    }
    public function getType() : string
    {
        return 'Expr_Assign';
    }
}
