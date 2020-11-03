<?php

declare (strict_types=1);
namespace _PhpScopercf327c47dfc5\PHPStan\PhpDocParser\Ast\Type;

class UnionTypeNode implements \_PhpScopercf327c47dfc5\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    /** @var TypeNode[] */
    public $types;
    public function __construct(array $types)
    {
        $this->types = $types;
    }
    public function __toString() : string
    {
        return '(' . \implode(' | ', $this->types) . ')';
    }
}
