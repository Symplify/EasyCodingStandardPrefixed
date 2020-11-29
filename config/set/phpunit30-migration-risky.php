<?php

declare (strict_types=1);
namespace _PhpScoper9d73a84b09ad;

use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertFixer;
use _PhpScoper9d73a84b09ad\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper9d73a84b09ad\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertFixer::class)->call('configure', [['target' => '3.0']]);
};
