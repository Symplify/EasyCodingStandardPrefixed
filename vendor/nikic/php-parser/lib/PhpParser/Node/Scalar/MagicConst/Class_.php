<?php

declare (strict_types=1);
namespace _PhpScoper971ef29294dd\PhpParser\Node\Scalar\MagicConst;

use _PhpScoper971ef29294dd\PhpParser\Node\Scalar\MagicConst;
class Class_ extends \_PhpScoper971ef29294dd\PhpParser\Node\Scalar\MagicConst
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
