<?php

declare (strict_types=1);
namespace _PhpScoper207eb8f99af3\Migrify\PhpConfigPrinter\Contract;

use _PhpScoper207eb8f99af3\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    public function match(string $rootKey, $key, $values) : bool;
    public function convertToMethodCall($key, $values) : \_PhpScoper207eb8f99af3\PhpParser\Node\Stmt\Expression;
}
