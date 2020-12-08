<?php

declare (strict_types=1);
namespace _PhpScoperf053e888b664\PhpParser\Node\Stmt;

use _PhpScoperf053e888b664\PhpParser\Node\Identifier;
use _PhpScoperf053e888b664\PhpParser\Node\Stmt;
class Goto_ extends \_PhpScoperf053e888b664\PhpParser\Node\Stmt
{
    /** @var Identifier Name of label to jump to */
    public $name;
    /**
     * Constructs a goto node.
     *
     * @param string|Identifier $name       Name of label to jump to
     * @param array             $attributes Additional attributes
     */
    public function __construct($name, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = \is_string($name) ? new \_PhpScoperf053e888b664\PhpParser\Node\Identifier($name) : $name;
    }
    public function getSubNodeNames() : array
    {
        return ['name'];
    }
    public function getType() : string
    {
        return 'Stmt_Goto';
    }
}
