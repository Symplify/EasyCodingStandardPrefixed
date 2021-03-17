<?php

declare (strict_types=1);
namespace _PhpScoper246d3630afdd;

use PhpCsFixer\Fixer\Alias\PowToExponentiationFixer;
use _PhpScoper246d3630afdd\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper246d3630afdd\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    \trigger_error('ECS set PHP_56_MIGRATION_RISKY is deprecated. Use more advanced and precise Rector instead (http://github.com/rectorphp/rector)');
    \sleep(3);
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\Alias\PowToExponentiationFixer::class);
};
