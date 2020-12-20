<?php

declare (strict_types=1);
namespace _PhpScoper7574e8786845;

use SlevomatCodingStandard\Sniffs\Files\LineLengthSniff;
use _PhpScoper7574e8786845\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper7574e8786845\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\SlevomatCodingStandard\Sniffs\Files\LineLengthSniff::class);
};
