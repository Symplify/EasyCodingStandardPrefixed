<?php

declare (strict_types=1);
namespace _PhpScopere050faf861e6\PhpParser\Node\Scalar\MagicConst;

use _PhpScopere050faf861e6\PhpParser\Node\Scalar\MagicConst;
class Namespace_ extends \_PhpScopere050faf861e6\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__NAMESPACE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Namespace';
    }
}
