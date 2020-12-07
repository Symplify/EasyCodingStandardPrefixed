<?php

declare (strict_types=1);
namespace _PhpScoperfa521053d812\PhpParser\Node\Expr\BinaryOp;

use _PhpScoperfa521053d812\PhpParser\Node\Expr\BinaryOp;
class Plus extends \_PhpScoperfa521053d812\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '+';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Plus';
    }
}
