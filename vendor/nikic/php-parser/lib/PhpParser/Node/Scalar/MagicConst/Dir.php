<?php

declare (strict_types=1);
namespace _PhpScoperea337ed74749\PhpParser\Node\Scalar\MagicConst;

use _PhpScoperea337ed74749\PhpParser\Node\Scalar\MagicConst;
class Dir extends \_PhpScoperea337ed74749\PhpParser\Node\Scalar\MagicConst
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
