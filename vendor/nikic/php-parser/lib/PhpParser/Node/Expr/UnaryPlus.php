<?php

declare (strict_types=1);
namespace _PhpScopere341acab57d4\PhpParser\Node\Expr;

use _PhpScopere341acab57d4\PhpParser\Node\Expr;
class UnaryPlus extends \_PhpScopere341acab57d4\PhpParser\Node\Expr
{
    /** @var Expr Expression */
    public $expr;
    /**
     * Constructs a unary plus node.
     *
     * @param Expr $expr       Expression
     * @param array               $attributes Additional attributes
     */
    public function __construct(\_PhpScopere341acab57d4\PhpParser\Node\Expr $expr, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->expr = $expr;
    }
    public function getSubNodeNames() : array
    {
        return ['expr'];
    }
    public function getType() : string
    {
        return 'Expr_UnaryPlus';
    }
}
