<?php

declare (strict_types=1);
namespace _PhpScoperaad82bb90a86\PhpParser\Node\Stmt;

use _PhpScoperaad82bb90a86\PhpParser\Node;
class Global_ extends \_PhpScoperaad82bb90a86\PhpParser\Node\Stmt
{
    /** @var Node\Expr[] Variables */
    public $vars;
    /**
     * Constructs a global variables list node.
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
        return 'Stmt_Global';
    }
}
