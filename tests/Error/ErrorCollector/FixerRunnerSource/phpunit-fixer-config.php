<?php

declare (strict_types=1);
namespace _PhpScoperb5b1090524db;

use PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use _PhpScoperb5b1090524db\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(PhpUnitStrictFixer::class);
};
