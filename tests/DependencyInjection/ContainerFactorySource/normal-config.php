<?php

declare (strict_types=1);
namespace _PhpScoper4575b9150b52;

use SlevomatCodingStandard\Sniffs\Files\LineLengthSniff;
use _PhpScoper4575b9150b52\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(LineLengthSniff::class);
};
