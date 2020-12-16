<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use _PhpScoperc75fd40d7a6e\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoperc75fd40d7a6e\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoperc75fd40d7a6e\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
