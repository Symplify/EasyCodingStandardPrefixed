<?php

declare (strict_types=1);
namespace _PhpScoperfa7254c25e18;

use SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff;
use _PhpScoperfa7254c25e18\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperfa7254c25e18\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff::class);
};
