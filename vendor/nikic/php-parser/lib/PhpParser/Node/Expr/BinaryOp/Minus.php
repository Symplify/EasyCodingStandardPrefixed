<?php

declare (strict_types=1);
namespace _PhpScoperad68e34a80c5\PhpParser\Node\Expr\BinaryOp;

use _PhpScoperad68e34a80c5\PhpParser\Node\Expr\BinaryOp;
class Minus extends \_PhpScoperad68e34a80c5\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '-';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Minus';
    }
}
