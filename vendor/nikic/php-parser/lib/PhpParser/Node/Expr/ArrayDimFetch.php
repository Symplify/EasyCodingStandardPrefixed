<?php

declare (strict_types=1);
namespace _PhpScoperf62d28230928\PhpParser\Node\Expr;

use _PhpScoperf62d28230928\PhpParser\Node\Expr;
class ArrayDimFetch extends \_PhpScoperf62d28230928\PhpParser\Node\Expr
{
    /** @var Expr Variable */
    public $var;
    /** @var null|Expr Array index / dim */
    public $dim;
    /**
     * Constructs an array index fetch node.
     *
     * @param Expr      $var        Variable
     * @param null|Expr $dim        Array index / dim
     * @param array     $attributes Additional attributes
     */
    public function __construct(\_PhpScoperf62d28230928\PhpParser\Node\Expr $var, \_PhpScoperf62d28230928\PhpParser\Node\Expr $dim = null, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->var = $var;
        $this->dim = $dim;
    }
    public function getSubNodeNames() : array
    {
        return ['var', 'dim'];
    }
    public function getType() : string
    {
        return 'Expr_ArrayDimFetch';
    }
}
