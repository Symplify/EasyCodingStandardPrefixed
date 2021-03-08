<?php

declare (strict_types=1);
namespace _PhpScoper4f42ead57614\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper4f42ead57614\PhpParser\Node\Expr\BinaryOp;
class ShiftRight extends \_PhpScoper4f42ead57614\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '>>';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_ShiftRight';
    }
}
