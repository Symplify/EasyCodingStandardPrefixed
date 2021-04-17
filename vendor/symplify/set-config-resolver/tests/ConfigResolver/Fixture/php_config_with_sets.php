<?php

declare (strict_types=1);
namespace _PhpScoper82a1412fb847;

use _PhpScoper82a1412fb847\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set('sets', ['some_php_set']);
};
