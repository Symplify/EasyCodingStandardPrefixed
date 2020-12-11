<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Contract\Converter;

use _PhpScoperea337ed74749\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScoperea337ed74749\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \_PhpScoperea337ed74749\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
