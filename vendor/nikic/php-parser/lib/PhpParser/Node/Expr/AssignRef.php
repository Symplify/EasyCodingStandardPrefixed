<?php

declare (strict_types=1);
namespace _PhpScoperf3db63c305b2\PhpParser\Node\Expr;

use _PhpScoperf3db63c305b2\PhpParser\Node\Expr;
class AssignRef extends \_PhpScoperf3db63c305b2\PhpParser\Node\Expr
{
    /** @var Expr Variable reference is assigned to */
    public $var;
    /** @var Expr Variable which is referenced */
    public $expr;
    /**
     * Constructs an assignment node.
     *
     * @param Expr  $var        Variable
     * @param Expr  $expr       Expression
     * @param array $attributes Additional attributes
     */
    public function __construct(\_PhpScoperf3db63c305b2\PhpParser\Node\Expr $var, \_PhpScoperf3db63c305b2\PhpParser\Node\Expr $expr, array $attributes = [])
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
        return 'Expr_AssignRef';
    }
}
