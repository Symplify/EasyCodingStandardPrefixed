<?php

declare (strict_types=1);
namespace _PhpScoper2fe14d6302bc\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper2fe14d6302bc\PhpParser\Node\Expr\BinaryOp;
class Mod extends \_PhpScoper2fe14d6302bc\PhpParser\Node\Expr\BinaryOp
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
