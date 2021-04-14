<?php

declare (strict_types=1);
namespace Symplify\ComposerJsonManipulator\DependencyInjection\Extension;

use _PhpScopercc9aec205203\Symfony\Component\Config\FileLocator;
use _PhpScopercc9aec205203\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScopercc9aec205203\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScopercc9aec205203\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class ComposerJsonManipulatorExtension extends \_PhpScopercc9aec205203\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, \_PhpScopercc9aec205203\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScopercc9aec205203\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScopercc9aec205203\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
