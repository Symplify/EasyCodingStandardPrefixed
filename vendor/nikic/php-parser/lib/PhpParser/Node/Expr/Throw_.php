<?php

declare (strict_types=1);
namespace _PhpScoper842c7347e6be\PhpParser\Node\Expr;

use _PhpScoper842c7347e6be\PhpParser\Node;
class Throw_ extends \_PhpScoper842c7347e6be\PhpParser\Node\Expr
{
    /** @var Node\Expr Expression */
    public $expr;
    /**
     * Constructs a throw expression node.
     *
     * @param Node\Expr $expr       Expression
     * @param array     $attributes Additional attributes
     */
    public function __construct(\_PhpScoper842c7347e6be\PhpParser\Node\Expr $expr, array $attributes = [])
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
        return 'Expr_Throw';
    }
}
