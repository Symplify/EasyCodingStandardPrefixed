<?php

declare (strict_types=1);
namespace _PhpScoper89c09b8e7101;

use _PhpScoper89c09b8e7101\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScoper89c09b8e7101\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Symplify\Skipper\ValueObject\Option::SKIP, [
        // windows slashes
        __DIR__ . '\\non-existing-path',
        __DIR__ . '/../Fixture',
        '*\\Mask\\*',
    ]);
};
