<?php

declare (strict_types=1);
namespace _PhpScoper967c4b7e296e\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper967c4b7e296e\PhpParser\Node\Expr\BinaryOp;
class SmallerOrEqual extends \_PhpScoper967c4b7e296e\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '<=';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_SmallerOrEqual';
    }
}
