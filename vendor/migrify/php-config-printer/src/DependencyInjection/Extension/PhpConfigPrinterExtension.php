<?php

declare (strict_types=1);
namespace _PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\DependencyInjection\Extension;

use _PhpScoperd9c3b46af121\Symfony\Component\Config\FileLocator;
use _PhpScoperd9c3b46af121\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperd9c3b46af121\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoperd9c3b46af121\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class PhpConfigPrinterExtension extends \_PhpScoperd9c3b46af121\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoperd9c3b46af121\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \_PhpScoperd9c3b46af121\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoperd9c3b46af121\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
