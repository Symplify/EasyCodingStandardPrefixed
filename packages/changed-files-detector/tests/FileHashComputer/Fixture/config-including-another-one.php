<?php

declare (strict_types=1);
namespace _PhpScoper8a8080b03ed6;

use _PhpScoper8a8080b03ed6\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/another-one.php');
};
