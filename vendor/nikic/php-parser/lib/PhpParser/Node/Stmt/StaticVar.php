<?php

declare (strict_types=1);
namespace _PhpScoper57210e33e43a\PhpParser\Node\Stmt;

use _PhpScoper57210e33e43a\PhpParser\Node;
use _PhpScoper57210e33e43a\PhpParser\Node\Expr;
class StaticVar extends \_PhpScoper57210e33e43a\PhpParser\Node\Stmt
{
    /** @var Expr\Variable Variable */
    public $var;
    /** @var null|Node\Expr Default value */
    public $default;
    /**
     * Constructs a static variable node.
     *
     * @param Expr\Variable  $var         Name
     * @param null|Node\Expr $default    Default value
     * @param array          $attributes Additional attributes
     */
    public function __construct(\_PhpScoper57210e33e43a\PhpParser\Node\Expr\Variable $var, \_PhpScoper57210e33e43a\PhpParser\Node\Expr $default = null, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->var = $var;
        $this->default = $default;
    }
    public function getSubNodeNames() : array
    {
        return ['var', 'default'];
    }
    public function getType() : string
    {
        return 'Stmt_StaticVar';
    }
}
