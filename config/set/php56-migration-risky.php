<?php

declare (strict_types=1);
namespace _PhpScopera04bf8e97c06;

use PhpCsFixer\Fixer\Alias\PowToExponentiationFixer;
use _PhpScopera04bf8e97c06\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopera04bf8e97c06\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\Alias\PowToExponentiationFixer::class);
};
