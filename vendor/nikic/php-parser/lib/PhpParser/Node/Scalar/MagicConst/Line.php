<?php

declare (strict_types=1);
namespace _PhpScoperb6ccec8ab642\PhpParser\Node\Scalar\MagicConst;

use _PhpScoperb6ccec8ab642\PhpParser\Node\Scalar\MagicConst;
class Line extends \_PhpScoperb6ccec8ab642\PhpParser\Node\Scalar\MagicConst
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
