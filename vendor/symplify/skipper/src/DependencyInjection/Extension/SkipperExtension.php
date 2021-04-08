<?php

declare (strict_types=1);
namespace Symplify\Skipper\DependencyInjection\Extension;

use _PhpScoper2f04ef4e8878\Symfony\Component\Config\FileLocator;
use _PhpScoper2f04ef4e8878\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper2f04ef4e8878\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoper2f04ef4e8878\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SkipperExtension extends \_PhpScoper2f04ef4e8878\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, \_PhpScoper2f04ef4e8878\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \_PhpScoper2f04ef4e8878\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoper2f04ef4e8878\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
