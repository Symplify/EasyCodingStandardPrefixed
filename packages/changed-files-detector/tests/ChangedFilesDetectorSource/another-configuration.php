<?php

declare (strict_types=1);
namespace _PhpScoper5a9febfbbe05;

use _PhpScoper5a9febfbbe05\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper5a9febfbbe05\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set('one', 'configuration-2');
};
