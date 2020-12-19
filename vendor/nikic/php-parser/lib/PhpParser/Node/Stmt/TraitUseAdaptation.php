<?php

declare (strict_types=1);
namespace _PhpScoper8b97b0dd6f5b\PhpParser\Node\Stmt;

use _PhpScoper8b97b0dd6f5b\PhpParser\Node;
abstract class TraitUseAdaptation extends \_PhpScoper8b97b0dd6f5b\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
