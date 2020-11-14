<?php

declare (strict_types=1);
namespace Symplify\MarkdownDiff\DependencyInjection\Extension;

use _PhpScoperd4937ee9b515\Symfony\Component\Config\FileLocator;
use _PhpScoperd4937ee9b515\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperd4937ee9b515\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoperd4937ee9b515\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class MarkdownDiffExtension extends \_PhpScoperd4937ee9b515\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoperd4937ee9b515\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScoperd4937ee9b515\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoperd4937ee9b515\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
