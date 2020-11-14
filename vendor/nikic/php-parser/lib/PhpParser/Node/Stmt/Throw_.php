<?php

declare (strict_types=1);
namespace _PhpScopercda2b863d098\PhpParser\Node\Stmt;

use _PhpScopercda2b863d098\PhpParser\Node;
class Throw_ extends \_PhpScopercda2b863d098\PhpParser\Node\Stmt
{
    /** @var Node\Expr Expression */
    public $expr;
    /**
     * Constructs a legacy throw statement node.
     *
     * @param Node\Expr $expr       Expression
     * @param array     $attributes Additional attributes
     */
    public function __construct(\_PhpScopercda2b863d098\PhpParser\Node\Expr $expr, array $attributes = [])
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
        return 'Stmt_Throw';
    }
}
