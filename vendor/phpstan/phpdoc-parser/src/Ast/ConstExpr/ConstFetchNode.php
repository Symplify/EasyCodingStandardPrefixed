<?php

declare (strict_types=1);
namespace _PhpScoper4d3fa30a680b\PHPStan\PhpDocParser\Ast\ConstExpr;

class ConstFetchNode implements \_PhpScoper4d3fa30a680b\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    /** @var string class name for class constants or empty string for non-class constants */
    public $className;
    /** @var string */
    public $name;
    public function __construct(string $className, string $name)
    {
        $this->className = $className;
        $this->name = $name;
    }
    public function __toString() : string
    {
        if ($this->className === '') {
            return $this->name;
        }
        return "{$this->className}::{$this->name}";
    }
}
