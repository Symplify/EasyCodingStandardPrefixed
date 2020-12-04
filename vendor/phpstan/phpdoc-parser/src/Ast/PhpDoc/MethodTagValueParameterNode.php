<?php

declare (strict_types=1);
namespace _PhpScoperc233426b15e0\PHPStan\PhpDocParser\Ast\PhpDoc;

use _PhpScoperc233426b15e0\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use _PhpScoperc233426b15e0\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoperc233426b15e0\PHPStan\PhpDocParser\Ast\Type\TypeNode;
class MethodTagValueParameterNode implements \_PhpScoperc233426b15e0\PHPStan\PhpDocParser\Ast\Node
{
    /** @var TypeNode|null */
    public $type;
    /** @var bool */
    public $isReference;
    /** @var bool */
    public $isVariadic;
    /** @var string */
    public $parameterName;
    /** @var ConstExprNode|null */
    public $defaultValue;
    public function __construct(?\_PhpScoperc233426b15e0\PHPStan\PhpDocParser\Ast\Type\TypeNode $type, bool $isReference, bool $isVariadic, string $parameterName, ?\_PhpScoperc233426b15e0\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $defaultValue)
    {
        $this->type = $type;
        $this->isReference = $isReference;
        $this->isVariadic = $isVariadic;
        $this->parameterName = $parameterName;
        $this->defaultValue = $defaultValue;
    }
    public function __toString() : string
    {
        $type = $this->type !== null ? "{$this->type} " : '';
        $isReference = $this->isReference ? '&' : '';
        $isVariadic = $this->isVariadic ? '...' : '';
        $default = $this->defaultValue !== null ? " = {$this->defaultValue}" : '';
        return "{$type}{$isReference}{$isVariadic}{$this->parameterName}{$default}";
    }
}
