<?php

declare (strict_types=1);
namespace _PhpScoperef5048aa2573\PhpParser\Node\Scalar\MagicConst;

use _PhpScoperef5048aa2573\PhpParser\Node\Scalar\MagicConst;
class Method extends \_PhpScoperef5048aa2573\PhpParser\Node\Scalar\MagicConst
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
