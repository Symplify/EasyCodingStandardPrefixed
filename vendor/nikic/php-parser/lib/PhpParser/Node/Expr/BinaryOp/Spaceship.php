<?php

declare (strict_types=1);
namespace _PhpScoper3b1d73f28e67\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper3b1d73f28e67\PhpParser\Node\Expr\BinaryOp;
class Spaceship extends \_PhpScoper3b1d73f28e67\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '<=>';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Spaceship';
    }
}
