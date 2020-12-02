<?php

declare (strict_types=1);
namespace _PhpScoper2d2a405cc0f8\PhpParser\Node\Stmt;

use _PhpScoper2d2a405cc0f8\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \_PhpScoper2d2a405cc0f8\PhpParser\Node\Stmt
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
