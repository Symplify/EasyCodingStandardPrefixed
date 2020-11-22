<?php

declare (strict_types=1);
namespace _PhpScoper6db4fde00cda\PHPStan\PhpDocParser\Ast\Type;

class CallableTypeNode implements \_PhpScoper6db4fde00cda\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    /** @var IdentifierTypeNode */
    public $identifier;
    /** @var CallableTypeParameterNode[] */
    public $parameters;
    /** @var TypeNode */
    public $returnType;
    public function __construct(\_PhpScoper6db4fde00cda\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $identifier, array $parameters, \_PhpScoper6db4fde00cda\PHPStan\PhpDocParser\Ast\Type\TypeNode $returnType)
    {
        $this->identifier = $identifier;
        $this->parameters = $parameters;
        $this->returnType = $returnType;
    }
    public function __toString() : string
    {
        $parameters = \implode(', ', $this->parameters);
        return "{$this->identifier}({$parameters}): {$this->returnType}";
    }
}
