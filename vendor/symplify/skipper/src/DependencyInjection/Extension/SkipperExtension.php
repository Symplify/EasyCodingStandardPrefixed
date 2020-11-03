<?php

declare (strict_types=1);
namespace Symplify\Skipper\DependencyInjection\Extension;

use _PhpScopera238de2e9b5a\Symfony\Component\Config\FileLocator;
use _PhpScopera238de2e9b5a\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScopera238de2e9b5a\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScopera238de2e9b5a\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SkipperExtension extends \_PhpScopera238de2e9b5a\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScopera238de2e9b5a\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \_PhpScopera238de2e9b5a\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScopera238de2e9b5a\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
