<?php

declare (strict_types=1);
namespace _PhpScoper18bd934c069f\PhpParser\Node\Scalar\MagicConst;

use _PhpScoper18bd934c069f\PhpParser\Node\Scalar\MagicConst;
class Method extends \_PhpScoper18bd934c069f\PhpParser\Node\Scalar\MagicConst
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
