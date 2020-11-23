<?php

declare (strict_types=1);
namespace _PhpScoperd4c5032f0671\PhpParser\Node\Expr;

use _PhpScoperd4c5032f0671\PhpParser\Node\Expr;
use _PhpScoperd4c5032f0671\PhpParser\Node\Identifier;
class PropertyFetch extends \_PhpScoperd4c5032f0671\PhpParser\Node\Expr
{
    /** @var Expr Variable holding object */
    public $var;
    /** @var Identifier|Expr Property name */
    public $name;
    /**
     * Constructs a function call node.
     *
     * @param Expr                   $var        Variable holding object
     * @param string|Identifier|Expr $name       Property name
     * @param array                  $attributes Additional attributes
     */
    public function __construct(\_PhpScoperd4c5032f0671\PhpParser\Node\Expr $var, $name, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->var = $var;
        $this->name = \is_string($name) ? new \_PhpScoperd4c5032f0671\PhpParser\Node\Identifier($name) : $name;
    }
    public function getSubNodeNames() : array
    {
        return ['var', 'name'];
    }
    public function getType() : string
    {
        return 'Expr_PropertyFetch';
    }
}
