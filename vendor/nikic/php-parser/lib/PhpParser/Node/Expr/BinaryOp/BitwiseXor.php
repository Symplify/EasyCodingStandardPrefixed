<?php

declare (strict_types=1);
namespace _PhpScoper13133e188f67\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper13133e188f67\PhpParser\Node\Expr\BinaryOp;
class BitwiseXor extends \_PhpScoper13133e188f67\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '^';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BitwiseXor';
    }
}
