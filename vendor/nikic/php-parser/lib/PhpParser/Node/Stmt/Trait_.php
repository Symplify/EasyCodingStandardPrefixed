<?php

declare (strict_types=1);
namespace _PhpScoper807f8e74693b\PhpParser\Node\Stmt;

use _PhpScoper807f8e74693b\PhpParser\Node;
class Trait_ extends \_PhpScoper807f8e74693b\PhpParser\Node\Stmt\ClassLike
{
    /**
     * Constructs a trait node.
     *
     * @param string|Node\Identifier $name Name
     * @param array  $subNodes   Array of the following optional subnodes:
     *                           'stmts'      => array(): Statements
     *                           'attrGroups' => array(): PHP attribute groups
     * @param array  $attributes Additional attributes
     */
    public function __construct($name, array $subNodes = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = \is_string($name) ? new \_PhpScoper807f8e74693b\PhpParser\Node\Identifier($name) : $name;
        $this->stmts = $subNodes['stmts'] ?? [];
        $this->attrGroups = $subNodes['attrGroups'] ?? [];
    }
    public function getSubNodeNames() : array
    {
        return ['attrGroups', 'name', 'stmts'];
    }
    public function getType() : string
    {
        return 'Stmt_Trait';
    }
}
