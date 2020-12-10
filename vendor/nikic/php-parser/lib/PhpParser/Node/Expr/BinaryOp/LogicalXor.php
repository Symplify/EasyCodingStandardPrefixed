<?php

declare (strict_types=1);
namespace _PhpScopera1a51450b61d\PhpParser\Node\Expr\BinaryOp;

use _PhpScopera1a51450b61d\PhpParser\Node\Expr\BinaryOp;
class LogicalXor extends \_PhpScopera1a51450b61d\PhpParser\Node\Expr\BinaryOp
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
