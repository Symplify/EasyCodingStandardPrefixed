<?php

declare (strict_types=1);
namespace _PhpScoper0ba97041430d\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper0ba97041430d\PhpParser\Node\Expr\BinaryOp;
class LogicalOr extends \_PhpScoper0ba97041430d\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return 'or';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_LogicalOr';
    }
}
