<?php

declare (strict_types=1);
namespace _PhpScopercae9e6ab5cea;

use _PhpScopercae9e6ab5cea\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('Symplify\\AutowireArrayParameter\\Tests\\SourcePhp8\\', __DIR__ . '/../SourcePhp8');
};
