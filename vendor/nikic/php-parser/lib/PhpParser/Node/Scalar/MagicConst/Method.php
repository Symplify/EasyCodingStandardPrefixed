<?php

declare (strict_types=1);
namespace _PhpScoperd9c3b46af121\PhpParser\Node\Scalar\MagicConst;

use _PhpScoperd9c3b46af121\PhpParser\Node\Scalar\MagicConst;
class Method extends \_PhpScoperd9c3b46af121\PhpParser\Node\Scalar\MagicConst
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
