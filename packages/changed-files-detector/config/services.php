<?php

declare (strict_types=1);
namespace _PhpScoper8b3c9ad56565;

use _PhpScoper8b3c9ad56565\Symfony\Component\Cache\Adapter\Psr16Adapter;
use _PhpScoper8b3c9ad56565\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScoper8b3c9ad56565\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper8b3c9ad56565\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('Symplify\\EasyCodingStandard\\ChangedFilesDetector\\', __DIR__ . '/../src');
    $services->set(Psr16Adapter::class);
    $services->set(TagAwareAdapter::class)->args(['$itemsPool' => service(Psr16Adapter::class), '$tagsPool' => service(Psr16Adapter::class)]);
};
