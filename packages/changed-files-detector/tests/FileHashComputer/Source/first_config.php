<?php

declare (strict_types=1);
namespace _PhpScoper7239e3eaf11a;

use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use _PhpScoper7239e3eaf11a\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(DeclareStrictTypesFixer::class);
};
