<?php

declare (strict_types=1);
namespace _PhpScoperc98ae2003489;

use SlevomatCodingStandard\Sniffs\Files\LineLengthSniff;
use _PhpScoperc98ae2003489\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperc98ae2003489\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\SlevomatCodingStandard\Sniffs\Files\LineLengthSniff::class);
};
