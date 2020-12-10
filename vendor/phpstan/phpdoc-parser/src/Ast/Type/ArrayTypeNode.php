<?php

declare (strict_types=1);
namespace _PhpScopera40fc53e636b\PHPStan\PhpDocParser\Ast\Type;

class ArrayTypeNode implements \_PhpScopera40fc53e636b\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    /** @var TypeNode */
    public $type;
    public function __construct(\_PhpScopera40fc53e636b\PHPStan\PhpDocParser\Ast\Type\TypeNode $type)
    {
        $this->type = $type;
    }
    public function __toString() : string
    {
        return $this->type . '[]';
    }
}
