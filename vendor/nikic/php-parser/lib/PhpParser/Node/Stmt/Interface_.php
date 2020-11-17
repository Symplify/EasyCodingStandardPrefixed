<?php

declare (strict_types=1);
namespace _PhpScoper967c4b7e296e\PhpParser\Node\Stmt;

use _PhpScoper967c4b7e296e\PhpParser\Node;
class Interface_ extends \_PhpScoper967c4b7e296e\PhpParser\Node\Stmt\ClassLike
{
    /** @var Node\Name[] Extended interfaces */
    public $extends;
    /**
     * Constructs a class node.
     *
     * @param string|Node\Identifier $name Name
     * @param array  $subNodes   Array of the following optional subnodes:
     *                           'extends' => array(): Name of extended interfaces
     *                           'stmts'   => array(): Statements
     * @param array  $attributes Additional attributes
     */
    public function __construct($name, array $subNodes = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = \is_string($name) ? new \_PhpScoper967c4b7e296e\PhpParser\Node\Identifier($name) : $name;
        $this->extends = $subNodes['extends'] ?? [];
        $this->stmts = $subNodes['stmts'] ?? [];
    }
    public function getSubNodeNames() : array
    {
        return ['name', 'extends', 'stmts'];
    }
    public function getType() : string
    {
        return 'Stmt_Interface';
    }
}
