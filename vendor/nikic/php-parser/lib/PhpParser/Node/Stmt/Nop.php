<?php

declare (strict_types=1);
namespace _PhpScopere5e7dca8c031\PhpParser\Node\Stmt;

use _PhpScopere5e7dca8c031\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \_PhpScopere5e7dca8c031\PhpParser\Node\Stmt
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
