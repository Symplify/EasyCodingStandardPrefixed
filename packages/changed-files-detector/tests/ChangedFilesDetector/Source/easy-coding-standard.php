<?php

declare (strict_types=1);
namespace _PhpScoper99c9619a6243;

use _PhpScoper99c9619a6243\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set('one', 'configuration-1');
};
