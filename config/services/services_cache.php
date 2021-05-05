<?php

declare (strict_types=1);
namespace _PhpScoperef2f7aa3581e;

use _PhpScoperef2f7aa3581e\Psr\Cache\CacheItemPoolInterface;
use _PhpScoperef2f7aa3581e\Psr\SimpleCache\CacheInterface;
use _PhpScoperef2f7aa3581e\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoperef2f7aa3581e\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScoperef2f7aa3581e\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScoperef2f7aa3581e\Symfony\Component\Cache\Psr16Cache;
use _PhpScoperef2f7aa3581e\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->set(Psr16Cache::class);
    $services->alias(CacheInterface::class, Psr16Cache::class);
    $services->set(FilesystemAdapter::class)->args(['$namespace' => '%cache_namespace%', '$defaultLifetime' => 0, '$directory' => '%cache_directory%']);
    $services->alias(CacheItemPoolInterface::class, FilesystemAdapter::class);
    $services->alias(TagAwareAdapterInterface::class, TagAwareAdapter::class);
};
