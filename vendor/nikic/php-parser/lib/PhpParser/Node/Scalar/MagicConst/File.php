<?php

declare (strict_types=1);
namespace _PhpScoper246d3630afdd\PhpParser\Node\Scalar\MagicConst;

use _PhpScoper246d3630afdd\PhpParser\Node\Scalar\MagicConst;
class File extends \_PhpScoper246d3630afdd\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__FILE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_File';
    }
}
