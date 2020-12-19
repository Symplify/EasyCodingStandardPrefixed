<?php

declare (strict_types=1);
namespace _PhpScopera6f918786d5c\PhpParser\Node\Expr\BinaryOp;

use _PhpScopera6f918786d5c\PhpParser\Node\Expr\BinaryOp;
class LogicalAnd extends \_PhpScopera6f918786d5c\PhpParser\Node\Expr\BinaryOp
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
