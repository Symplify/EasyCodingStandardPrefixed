<?php

declare (strict_types=1);
namespace Symplify\Skipper\DependencyInjection\Extension;

use _PhpScoper78af57a363a0\Symfony\Component\Config\FileLocator;
use _PhpScoper78af57a363a0\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper78af57a363a0\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoper78af57a363a0\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SkipperExtension extends \_PhpScoper78af57a363a0\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoper78af57a363a0\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \_PhpScoper78af57a363a0\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoper78af57a363a0\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
