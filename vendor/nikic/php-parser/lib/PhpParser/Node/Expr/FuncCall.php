<?php

declare (strict_types=1);
namespace _PhpScoperf053e888b664\PhpParser\Node\Expr;

use _PhpScoperf053e888b664\PhpParser\Node;
use _PhpScoperf053e888b664\PhpParser\Node\Expr;
class FuncCall extends \_PhpScoperf053e888b664\PhpParser\Node\Expr
{
    /** @var Node\Name|Expr Function name */
    public $name;
    /** @var Node\Arg[] Arguments */
    public $args;
    /**
     * Constructs a function call node.
     *
     * @param Node\Name|Expr $name       Function name
     * @param Node\Arg[]     $args       Arguments
     * @param array          $attributes Additional attributes
     */
    public function __construct($name, array $args = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = $name;
        $this->args = $args;
    }
    public function getSubNodeNames() : array
    {
        return ['name', 'args'];
    }
    public function getType() : string
    {
        return 'Expr_FuncCall';
    }
}
