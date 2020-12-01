<?php

declare (strict_types=1);
namespace _PhpScoper6dbb854503f8\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper6dbb854503f8\PhpParser\Node\Expr\BinaryOp;
class SmallerOrEqual extends \_PhpScoper6dbb854503f8\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '<=';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_SmallerOrEqual';
    }
}
