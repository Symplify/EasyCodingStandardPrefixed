<?php

declare (strict_types=1);
namespace _PhpScoper9613f3fac51d\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper9613f3fac51d\PhpParser\Node\Expr\BinaryOp;
class LogicalXor extends \_PhpScoper9613f3fac51d\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return 'xor';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_LogicalXor';
    }
}
