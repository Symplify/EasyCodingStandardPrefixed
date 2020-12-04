<?php

declare (strict_types=1);
namespace _PhpScopera04bf8e97c06\PhpParser\Node\Stmt;

use _PhpScopera04bf8e97c06\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \_PhpScopera04bf8e97c06\PhpParser\Node\Stmt
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
