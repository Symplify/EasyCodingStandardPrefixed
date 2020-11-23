<?php

declare (strict_types=1);
namespace _PhpScoper7b8580219c59\PHPStan\PhpDocParser\Ast\Type;

class NullableTypeNode implements \_PhpScoper7b8580219c59\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    /** @var TypeNode */
    public $type;
    public function __construct(\_PhpScoper7b8580219c59\PHPStan\PhpDocParser\Ast\Type\TypeNode $type)
    {
        $this->type = $type;
    }
    public function __toString() : string
    {
        return '?' . $this->type;
    }
}
