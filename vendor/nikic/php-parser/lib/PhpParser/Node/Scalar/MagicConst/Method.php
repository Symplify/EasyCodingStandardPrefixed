<?php

declare (strict_types=1);
namespace _PhpScoperea337ed74749\PhpParser\Node\Scalar\MagicConst;

use _PhpScoperea337ed74749\PhpParser\Node\Scalar\MagicConst;
class Method extends \_PhpScoperea337ed74749\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__METHOD__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Method';
    }
}
