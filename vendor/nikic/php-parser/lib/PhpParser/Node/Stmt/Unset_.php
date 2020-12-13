<?php

declare (strict_types=1);
namespace _PhpScoper78af57a363a0\PhpParser\Node\Stmt;

use _PhpScoper78af57a363a0\PhpParser\Node;
class Unset_ extends \_PhpScoper78af57a363a0\PhpParser\Node\Stmt
{
    /** @var Node\Expr[] Variables to unset */
    public $vars;
    /**
     * Constructs an unset node.
     *
     * @param Node\Expr[] $vars       Variables to unset
     * @param array       $attributes Additional attributes
     */
    public function __construct(array $vars, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->vars = $vars;
    }
    public function getSubNodeNames() : array
    {
        return ['vars'];
    }
    public function getType() : string
    {
        return 'Stmt_Unset';
    }
}
