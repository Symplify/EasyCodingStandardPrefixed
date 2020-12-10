<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory;

use _PhpScoper58a0a169dcfb\PhpParser\BuilderHelpers;
use _PhpScoper58a0a169dcfb\PhpParser\Node\Expr;
use _PhpScoper58a0a169dcfb\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper58a0a169dcfb\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper58a0a169dcfb\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper58a0a169dcfb\PhpParser\Node\Name;
use _PhpScoper58a0a169dcfb\PhpParser\Node\Name\FullyQualified;
use _PhpScoper58a0a169dcfb\PhpParser\Node\Scalar\MagicConst\Dir;
use _PhpScoper58a0a169dcfb\PhpParser\Node\Scalar\String_;
final class CommonNodeFactory
{
    public function createAbsoluteDirExpr($argument) : \_PhpScoper58a0a169dcfb\PhpParser\Node\Expr
    {
        if ($argument === '') {
            return new \_PhpScoper58a0a169dcfb\PhpParser\Node\Scalar\String_('');
        }
        if (\is_string($argument)) {
            // preslash with dir
            $argument = '/' . $argument;
        }
        $argumentValue = \_PhpScoper58a0a169dcfb\PhpParser\BuilderHelpers::normalizeValue($argument);
        if ($argumentValue instanceof \_PhpScoper58a0a169dcfb\PhpParser\Node\Scalar\String_) {
            $argumentValue = new \_PhpScoper58a0a169dcfb\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScoper58a0a169dcfb\PhpParser\Node\Scalar\MagicConst\Dir(), $argumentValue);
        }
        return $argumentValue;
    }
    public function createClassReference(string $className) : \_PhpScoper58a0a169dcfb\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->createConstFetch($className, 'class');
    }
    public function createConstFetch(string $className, string $constantName) : \_PhpScoper58a0a169dcfb\PhpParser\Node\Expr\ClassConstFetch
    {
        return new \_PhpScoper58a0a169dcfb\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoper58a0a169dcfb\PhpParser\Node\Name\FullyQualified($className), $constantName);
    }
    public function createFalse() : \_PhpScoper58a0a169dcfb\PhpParser\Node\Expr\ConstFetch
    {
        return new \_PhpScoper58a0a169dcfb\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper58a0a169dcfb\PhpParser\Node\Name('false'));
    }
}
