<?php

declare (strict_types=1);
namespace _PhpScoperfaaf57618f34;

use PhpCsFixer\Fixer\Alias\PowToExponentiationFixer;
use _PhpScoperfaaf57618f34\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperfaaf57618f34\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\Alias\PowToExponentiationFixer::class);
};
