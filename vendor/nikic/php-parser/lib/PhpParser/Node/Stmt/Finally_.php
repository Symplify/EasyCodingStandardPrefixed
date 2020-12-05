<?php

declare (strict_types=1);
namespace _PhpScoper87c77ad5700d\PhpParser\Node\Stmt;

use _PhpScoper87c77ad5700d\PhpParser\Node;
class Finally_ extends \_PhpScoper87c77ad5700d\PhpParser\Node\Stmt
{
    /** @var Node\Stmt[] Statements */
    public $stmts;
    /**
     * Constructs a finally node.
     *
     * @param Node\Stmt[] $stmts      Statements
     * @param array       $attributes Additional attributes
     */
    public function __construct(array $stmts = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->stmts = $stmts;
    }
    public function getSubNodeNames() : array
    {
        return ['stmts'];
    }
    public function getType() : string
    {
        return 'Stmt_Finally';
    }
}
