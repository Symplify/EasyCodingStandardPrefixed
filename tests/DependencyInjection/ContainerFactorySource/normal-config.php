<?php

declare (strict_types=1);
namespace _PhpScoper356bfb655d08;

use SlevomatCodingStandard\Sniffs\Files\LineLengthSniff;
use _PhpScoper356bfb655d08\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper356bfb655d08\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\SlevomatCodingStandard\Sniffs\Files\LineLengthSniff::class);
};
