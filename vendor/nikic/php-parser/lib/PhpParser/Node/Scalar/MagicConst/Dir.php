<?php

declare (strict_types=1);
namespace _PhpScopercb576ca159b5\PhpParser\Node\Scalar\MagicConst;

use _PhpScopercb576ca159b5\PhpParser\Node\Scalar\MagicConst;
class Dir extends \_PhpScopercb576ca159b5\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__DIR__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Dir';
    }
}
