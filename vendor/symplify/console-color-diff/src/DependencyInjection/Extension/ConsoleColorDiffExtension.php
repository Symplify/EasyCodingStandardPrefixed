<?php

declare (strict_types=1);
namespace Symplify\ConsoleColorDiff\DependencyInjection\Extension;

use _PhpScoper86aebf8cf357\Symfony\Component\Config\FileLocator;
use _PhpScoper86aebf8cf357\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper86aebf8cf357\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoper86aebf8cf357\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class ConsoleColorDiffExtension extends \_PhpScoper86aebf8cf357\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, \_PhpScoper86aebf8cf357\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScoper86aebf8cf357\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoper86aebf8cf357\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
