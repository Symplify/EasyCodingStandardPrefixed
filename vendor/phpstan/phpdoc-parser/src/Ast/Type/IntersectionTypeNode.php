<?php

declare (strict_types=1);
namespace _PhpScoper37a255897161\PHPStan\PhpDocParser\Ast\Type;

class IntersectionTypeNode implements \_PhpScoper37a255897161\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    /** @var TypeNode[] */
    public $types;
    public function __construct(array $types)
    {
        $this->types = $types;
    }
    public function __toString() : string
    {
        return '(' . \implode(' & ', $this->types) . ')';
    }
}
