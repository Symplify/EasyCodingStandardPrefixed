<?php

declare (strict_types=1);
namespace _PhpScoper78e1a27e740b;

use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/common/*.php');
};
