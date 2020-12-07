<?php

declare (strict_types=1);
namespace _PhpScoper18bd934c069f\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper18bd934c069f\PhpParser\Node\Expr\BinaryOp;
class Mul extends \_PhpScoper18bd934c069f\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '*';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Mul';
    }
}
