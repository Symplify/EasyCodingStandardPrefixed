<?php

declare (strict_types=1);
namespace _PhpScopere015d8a3273c\PHPStan\PhpDocParser\Ast\PhpDoc;

class InvalidTagValueNode implements \_PhpScopere015d8a3273c\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    /** @var string (may be empty) */
    public $value;
    /** @var \PHPStan\PhpDocParser\Parser\ParserException */
    public $exception;
    public function __construct(string $value, \_PhpScopere015d8a3273c\PHPStan\PhpDocParser\Parser\ParserException $exception)
    {
        $this->value = $value;
        $this->exception = $exception;
    }
    public function __toString() : string
    {
        return $this->value;
    }
}
