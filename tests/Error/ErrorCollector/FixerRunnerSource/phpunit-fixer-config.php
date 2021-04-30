<?php

declare (strict_types=1);
namespace _PhpScopera658fe86acec;

use PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use _PhpScopera658fe86acec\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(PhpUnitStrictFixer::class);
};
