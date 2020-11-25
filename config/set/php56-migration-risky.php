<?php

declare (strict_types=1);
namespace _PhpScoper38a7d00685f8;

use PhpCsFixer\Fixer\Alias\PowToExponentiationFixer;
use _PhpScoper38a7d00685f8\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper38a7d00685f8\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\Alias\PowToExponentiationFixer::class);
};
