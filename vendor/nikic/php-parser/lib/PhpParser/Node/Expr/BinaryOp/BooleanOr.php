<?php

declare (strict_types=1);
namespace _PhpScoper37a255897161\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper37a255897161\PhpParser\Node\Expr\BinaryOp;
class BooleanOr extends \_PhpScoper37a255897161\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '||';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BooleanOr';
    }
}
