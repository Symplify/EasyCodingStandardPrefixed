<?php

declare (strict_types=1);
namespace _PhpScopere4fa57261c04\PhpParser\Node\Scalar\MagicConst;

use _PhpScopere4fa57261c04\PhpParser\Node\Scalar\MagicConst;
class Line extends \_PhpScopere4fa57261c04\PhpParser\Node\Scalar\MagicConst
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
