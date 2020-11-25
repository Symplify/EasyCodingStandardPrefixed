<?php

declare (strict_types=1);
namespace _PhpScoper2a48669dad72\PHPStan\PhpDocParser\Ast\Type;

class NullableTypeNode implements \_PhpScoper2a48669dad72\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    /** @var TypeNode */
    public $type;
    public function __construct(\_PhpScoper2a48669dad72\PHPStan\PhpDocParser\Ast\Type\TypeNode $type)
    {
        $this->type = $type;
    }
    public function __toString() : string
    {
        return '?' . $this->type;
    }
}
