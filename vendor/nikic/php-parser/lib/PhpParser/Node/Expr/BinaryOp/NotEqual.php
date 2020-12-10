<?php

declare (strict_types=1);
namespace _PhpScoper908feaf49cd8\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper908feaf49cd8\PhpParser\Node\Expr\BinaryOp;
class NotEqual extends \_PhpScoper908feaf49cd8\PhpParser\Node\Expr\BinaryOp
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
