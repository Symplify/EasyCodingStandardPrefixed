<?php

declare (strict_types=1);
namespace _PhpScoper8e2d8a2760d1;

use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use _PhpScoper8e2d8a2760d1\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8e2d8a2760d1\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\Basic\EncodingFixer::class);
    $services->set(\PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer::class);
};
