<?php

declare (strict_types=1);
namespace _PhpScopercae980ebf12d;

use PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use _PhpScopercae980ebf12d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopercae980ebf12d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer::class);
};
