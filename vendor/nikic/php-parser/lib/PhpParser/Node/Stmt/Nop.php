<?php

declare (strict_types=1);
namespace _PhpScoper7c3fefba1fb9\PhpParser\Node\Stmt;

use _PhpScoper7c3fefba1fb9\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \_PhpScoper7c3fefba1fb9\PhpParser\Node\Stmt
{
    public function getSubNodeNames() : array
    {
        return [];
    }
    public function getType() : string
    {
        return 'Stmt_Nop';
    }
}
