<?php

declare (strict_types=1);
namespace _PhpScopercae980ebf12d\PhpParser\Node\Scalar\MagicConst;

use _PhpScopercae980ebf12d\PhpParser\Node\Scalar\MagicConst;
class Class_ extends \_PhpScopercae980ebf12d\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__CLASS__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Class';
    }
}
