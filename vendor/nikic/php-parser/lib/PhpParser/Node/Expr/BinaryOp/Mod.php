<?php

declare (strict_types=1);
namespace _PhpScopercb217fd4e736\PhpParser\Node\Expr\BinaryOp;

use _PhpScopercb217fd4e736\PhpParser\Node\Expr\BinaryOp;
class Mod extends \_PhpScopercb217fd4e736\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '%';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Mod';
    }
}
