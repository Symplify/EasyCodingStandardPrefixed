<?php

declare (strict_types=1);
namespace _PhpScoper666af036e800\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper666af036e800\PhpParser\Node\Expr\BinaryOp;
class NotEqual extends \_PhpScoper666af036e800\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '!=';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_NotEqual';
    }
}
