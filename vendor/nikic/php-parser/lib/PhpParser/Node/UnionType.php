<?php

declare (strict_types=1);
namespace _PhpScoper3fa05b4669af\PhpParser\Node;

use _PhpScoper3fa05b4669af\PhpParser\NodeAbstract;
class UnionType extends \_PhpScoper3fa05b4669af\PhpParser\NodeAbstract
{
    /** @var (Identifier|Name)[] Types */
    public $types;
    /**
     * Constructs a union type.
     *
     * @param (Identifier|Name)[] $types      Types
     * @param array               $attributes Additional attributes
     */
    public function __construct(array $types, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->types = $types;
    }
    public function getSubNodeNames() : array
    {
        return ['types'];
    }
    public function getType() : string
    {
        return 'UnionType';
    }
}
