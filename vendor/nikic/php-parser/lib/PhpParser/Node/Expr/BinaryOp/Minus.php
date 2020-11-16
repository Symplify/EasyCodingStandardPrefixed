<?php

declare (strict_types=1);
namespace _PhpScopera9d6b451df71\PhpParser\Node\Expr\BinaryOp;

use _PhpScopera9d6b451df71\PhpParser\Node\Expr\BinaryOp;
class Minus extends \_PhpScopera9d6b451df71\PhpParser\Node\Expr\BinaryOp
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
