<?php

declare (strict_types=1);
namespace _PhpScoper0270f1d35181\PhpParser\Node\Expr;

use _PhpScoper0270f1d35181\PhpParser\Node;
use _PhpScoper0270f1d35181\PhpParser\Node\MatchArm;
class Match_ extends \_PhpScoper0270f1d35181\PhpParser\Node\Expr
{
    /** @var Node\Expr */
    public $cond;
    /** @var MatchArm[] */
    public $arms;
    /**
     * @param MatchArm[] $arms
     */
    public function __construct(\_PhpScoper0270f1d35181\PhpParser\Node\Expr $cond, array $arms = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->cond = $cond;
        $this->arms = $arms;
    }
    public function getSubNodeNames() : array
    {
        return ['cond', 'arms'];
    }
    public function getType() : string
    {
        return 'Expr_Match';
    }
}
