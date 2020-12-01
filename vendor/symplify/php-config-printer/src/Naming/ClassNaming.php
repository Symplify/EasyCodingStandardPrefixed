<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use _PhpScoperad68e34a80c5\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoperad68e34a80c5\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoperad68e34a80c5\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
