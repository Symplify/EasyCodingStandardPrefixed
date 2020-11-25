<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Contract\Converter;

use _PhpScoper38a7d00685f8\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScoper38a7d00685f8\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \_PhpScoper38a7d00685f8\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
