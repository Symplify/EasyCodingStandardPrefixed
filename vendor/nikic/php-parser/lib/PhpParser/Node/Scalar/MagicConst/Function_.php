<?php

declare (strict_types=1);
namespace _PhpScoperad68e34a80c5\PhpParser\Node\Scalar\MagicConst;

use _PhpScoperad68e34a80c5\PhpParser\Node\Scalar\MagicConst;
class Function_ extends \_PhpScoperad68e34a80c5\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__FUNCTION__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Function';
    }
}
