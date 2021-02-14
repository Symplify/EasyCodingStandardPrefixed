<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use _PhpScoper89c09b8e7101\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoper89c09b8e7101\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoper89c09b8e7101\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
