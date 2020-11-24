<?php

declare (strict_types=1);
namespace _PhpScoper7c0f822a05e1\PhpParser\Node\Stmt;

use _PhpScoper7c0f822a05e1\PhpParser\Node;
class Continue_ extends \_PhpScoper7c0f822a05e1\PhpParser\Node\Stmt
{
    /** @var null|Node\Expr Number of loops to continue */
    public $num;
    /**
     * Constructs a continue node.
     *
     * @param null|Node\Expr $num        Number of loops to continue
     * @param array          $attributes Additional attributes
     */
    public function __construct(\_PhpScoper7c0f822a05e1\PhpParser\Node\Expr $num = null, array $attributes = [])
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
        return 'Stmt_Continue';
    }
}
