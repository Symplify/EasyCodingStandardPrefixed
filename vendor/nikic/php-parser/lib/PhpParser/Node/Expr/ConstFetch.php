<?php

declare (strict_types=1);
namespace _PhpScopere341acab57d4\PhpParser\Node\Expr;

use _PhpScopere341acab57d4\PhpParser\Node\Expr;
use _PhpScopere341acab57d4\PhpParser\Node\Name;
class ConstFetch extends \_PhpScopere341acab57d4\PhpParser\Node\Expr
{
    /** @var Name Constant name */
    public $name;
    /**
     * Constructs a const fetch node.
     *
     * @param Name  $name       Constant name
     * @param array $attributes Additional attributes
     */
    public function __construct(\_PhpScopere341acab57d4\PhpParser\Node\Name $name, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = $name;
    }
    public function getSubNodeNames() : array
    {
        return ['name'];
    }
    public function getType() : string
    {
        return 'Expr_ConstFetch';
    }
}
