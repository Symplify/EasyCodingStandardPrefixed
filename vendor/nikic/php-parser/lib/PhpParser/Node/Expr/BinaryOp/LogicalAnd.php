<?php

declare (strict_types=1);
namespace _PhpScoper2a48669dad72\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper2a48669dad72\PhpParser\Node\Expr\BinaryOp;
class LogicalAnd extends \_PhpScoper2a48669dad72\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return 'and';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_LogicalAnd';
    }
}
