<?php

declare (strict_types=1);
namespace _PhpScoperaac5f7c652e4\PhpParser\Node\Scalar\MagicConst;

use _PhpScoperaac5f7c652e4\PhpParser\Node\Scalar\MagicConst;
class Line extends \_PhpScoperaac5f7c652e4\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__LINE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Line';
    }
}
