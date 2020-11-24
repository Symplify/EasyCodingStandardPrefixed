<?php

declare (strict_types=1);
namespace _PhpScoperf3d5f0921050\PhpParser\Node\Stmt;

use _PhpScoperf3d5f0921050\PhpParser\Node;
class Else_ extends \_PhpScoperf3d5f0921050\PhpParser\Node\Stmt
{
    /** @var Node\Stmt[] Statements */
    public $stmts;
    /**
     * Constructs an else node.
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
        return 'Stmt_Else';
    }
}
