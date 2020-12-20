<?php

declare (strict_types=1);
namespace _PhpScoper57210e33e43a\PhpParser\Node\Expr;

use _PhpScoper57210e33e43a\PhpParser\Node\Arg;
use _PhpScoper57210e33e43a\PhpParser\Node\Expr;
use _PhpScoper57210e33e43a\PhpParser\Node\Identifier;
class NullsafeMethodCall extends \_PhpScoper57210e33e43a\PhpParser\Node\Expr
{
    /** @var Expr Variable holding object */
    public $var;
    /** @var Identifier|Expr Method name */
    public $name;
    /** @var Arg[] Arguments */
    public $args;
    /**
     * Constructs a nullsafe method call node.
     *
     * @param Expr                   $var        Variable holding object
     * @param string|Identifier|Expr $name       Method name
     * @param Arg[]                  $args       Arguments
     * @param array                  $attributes Additional attributes
     */
    public function __construct(\_PhpScoper57210e33e43a\PhpParser\Node\Expr $var, $name, array $args = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->var = $var;
        $this->name = \is_string($name) ? new \_PhpScoper57210e33e43a\PhpParser\Node\Identifier($name) : $name;
        $this->args = $args;
    }
    public function getSubNodeNames() : array
    {
        return ['var', 'name', 'args'];
    }
    public function getType() : string
    {
        return 'Expr_NullsafeMethodCall';
    }
}
