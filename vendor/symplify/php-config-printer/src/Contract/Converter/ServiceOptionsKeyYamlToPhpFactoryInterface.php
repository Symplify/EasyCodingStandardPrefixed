<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Contract\Converter;

use _PhpScoperb44a315fec16\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScoperb44a315fec16\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \_PhpScoperb44a315fec16\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
