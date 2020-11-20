<?php

declare (strict_types=1);
namespace _PhpScoperb6d4bd368bd9\PhpParser\Node\Expr;

use _PhpScoperb6d4bd368bd9\PhpParser\Node\Expr;
class PostDec extends \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr
{
    /** @var Expr Variable */
    public $var;
    /**
     * Constructs a post decrement node.
     *
     * @param Expr  $var        Variable
     * @param array $attributes Additional attributes
     */
    public function __construct(\_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr $var, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->var = $var;
    }
    public function getSubNodeNames() : array
    {
        return ['var'];
    }
    public function getType() : string
    {
        return 'Expr_PostDec';
    }
}
