<?php

declare (strict_types=1);
namespace _PhpScoperdf6a0b341030\Migrify\PhpConfigPrinter\Contract;

use _PhpScoperdf6a0b341030\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    public function match(string $key, $values) : bool;
    public function convertToMethodCall(string $key, $values) : \_PhpScoperdf6a0b341030\PhpParser\Node\Stmt\Expression;
}
