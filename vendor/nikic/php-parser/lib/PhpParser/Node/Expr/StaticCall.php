<?php

declare (strict_types=1);
namespace _PhpScopercb576ca159b5\PhpParser\Node\Expr;

use _PhpScopercb576ca159b5\PhpParser\Node;
use _PhpScopercb576ca159b5\PhpParser\Node\Expr;
use _PhpScopercb576ca159b5\PhpParser\Node\Identifier;
class StaticCall extends \_PhpScopercb576ca159b5\PhpParser\Node\Expr
{
    /** @var Node\Name|Expr Class name */
    public $class;
    /** @var Identifier|Expr Method name */
    public $name;
    /** @var Node\Arg[] Arguments */
    public $args;
    /**
     * Constructs a static method call node.
     *
     * @param Node\Name|Expr         $class      Class name
     * @param string|Identifier|Expr $name       Method name
     * @param Node\Arg[]             $args       Arguments
     * @param array                  $attributes Additional attributes
     */
    public function __construct($class, $name, array $args = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->class = $class;
        $this->name = \is_string($name) ? new \_PhpScopercb576ca159b5\PhpParser\Node\Identifier($name) : $name;
        $this->args = $args;
    }
    public function getSubNodeNames() : array
    {
        return ['class', 'name', 'args'];
    }
    public function getType() : string
    {
        return 'Expr_StaticCall';
    }
}
