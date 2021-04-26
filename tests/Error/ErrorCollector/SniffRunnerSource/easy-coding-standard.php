<?php

declare (strict_types=1);
namespace _PhpScoper85e989d55df2;

use PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\ArrayIndentSniff;
use _PhpScoper85e989d55df2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(ArrayIndentSniff::class);
};
