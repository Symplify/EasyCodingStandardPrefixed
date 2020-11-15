<?php

declare (strict_types=1);
namespace _PhpScoperd9c3b46af121\PhpParser\Node\Stmt;

use _PhpScoperd9c3b46af121\PhpParser\Node;
class Break_ extends \_PhpScoperd9c3b46af121\PhpParser\Node\Stmt
{
    /** @var null|Node\Expr Number of loops to break */
    public $num;
    /**
     * Constructs a break node.
     *
     * @param null|Node\Expr $num        Number of loops to break
     * @param array          $attributes Additional attributes
     */
    public function __construct(\_PhpScoperd9c3b46af121\PhpParser\Node\Expr $num = null, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->num = $num;
    }
    public function getSubNodeNames() : array
    {
        return ['num'];
    }
    public function getType() : string
    {
        return 'Stmt_Break';
    }
}
