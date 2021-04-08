<?php

declare (strict_types=1);
namespace _PhpScoper9a024705919c;

use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use _PhpScoper9a024705919c\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper9a024705919c\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/simple-config.php');
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer::class);
};
