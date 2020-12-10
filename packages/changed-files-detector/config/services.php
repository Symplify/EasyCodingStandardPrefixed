<?php

declare (strict_types=1);
namespace _PhpScopera40fc53e636b;

use _PhpScopera40fc53e636b\Symfony\Component\Cache\Adapter\Psr16Adapter;
use _PhpScopera40fc53e636b\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScopera40fc53e636b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScopera40fc53e636b\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScopera40fc53e636b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('Symplify\\EasyCodingStandard\\ChangedFilesDetector\\', __DIR__ . '/../src');
    $services->set(\_PhpScopera40fc53e636b\Symfony\Component\Cache\Adapter\Psr16Adapter::class);
    $services->set(\_PhpScopera40fc53e636b\Symfony\Component\Cache\Adapter\TagAwareAdapter::class)->args(['$itemsPool' => \_PhpScopera40fc53e636b\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScopera40fc53e636b\Symfony\Component\Cache\Adapter\Psr16Adapter::class), '$tagsPool' => \_PhpScopera40fc53e636b\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScopera40fc53e636b\Symfony\Component\Cache\Adapter\Psr16Adapter::class)]);
};
