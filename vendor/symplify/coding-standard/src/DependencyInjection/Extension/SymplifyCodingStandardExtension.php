<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\DependencyInjection\Extension;

use _PhpScoper8b3c9ad56565\Symfony\Component\Config\FileLocator;
use _PhpScoper8b3c9ad56565\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper8b3c9ad56565\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoper8b3c9ad56565\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SymplifyCodingStandardExtension extends Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
