<?php

declare (strict_types=1);
namespace _PhpScoper2a8ad010dfbd\PhpParser\Node\Scalar\MagicConst;

use _PhpScoper2a8ad010dfbd\PhpParser\Node\Scalar\MagicConst;
class Method extends \_PhpScoper2a8ad010dfbd\PhpParser\Node\Scalar\MagicConst
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
