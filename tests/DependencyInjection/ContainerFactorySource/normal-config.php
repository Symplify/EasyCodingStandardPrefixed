<?php

declare (strict_types=1);
namespace _PhpScoper60081b922775;

use SlevomatCodingStandard\Sniffs\Files\LineLengthSniff;
use _PhpScoper60081b922775\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper60081b922775\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\SlevomatCodingStandard\Sniffs\Files\LineLengthSniff::class);
};
