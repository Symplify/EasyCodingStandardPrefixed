<?php

declare (strict_types=1);
namespace _PhpScoperb6ccec8ab642;

use SlevomatCodingStandard\Sniffs\Files\LineLengthSniff;
use _PhpScoperb6ccec8ab642\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb6ccec8ab642\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\SlevomatCodingStandard\Sniffs\Files\LineLengthSniff::class);
};
