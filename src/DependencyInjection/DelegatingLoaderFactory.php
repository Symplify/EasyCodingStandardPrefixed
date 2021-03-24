<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\DependencyInjection;

use _PhpScoperc98ae2003489\Symfony\Component\Config\FileLocator as SimpleFileLocator;
use _PhpScoperc98ae2003489\Symfony\Component\Config\Loader\DelegatingLoader;
use _PhpScoperc98ae2003489\Symfony\Component\Config\Loader\GlobFileLoader;
use _PhpScoperc98ae2003489\Symfony\Component\Config\Loader\LoaderResolver;
use _PhpScoperc98ae2003489\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperc98ae2003489\Symfony\Component\HttpKernel\Config\FileLocator;
use _PhpScoperc98ae2003489\Symfony\Component\HttpKernel\KernelInterface;
use Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
final class DelegatingLoaderFactory
{
    public function createFromContainerBuilderAndKernel(\_PhpScoperc98ae2003489\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \_PhpScoperc98ae2003489\Symfony\Component\HttpKernel\KernelInterface $kernel) : \_PhpScoperc98ae2003489\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $kernelFileLocator = new \_PhpScoperc98ae2003489\Symfony\Component\HttpKernel\Config\FileLocator($kernel);
        return $this->createFromContainerBuilderAndFileLocator($containerBuilder, $kernelFileLocator);
    }
    /**
     * For tests
     */
    public function createContainerBuilderAndConfig(\_PhpScoperc98ae2003489\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $config) : \_PhpScoperc98ae2003489\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $directory = \dirname($config);
        $fileLocator = new \_PhpScoperc98ae2003489\Symfony\Component\Config\FileLocator($directory);
        return $this->createFromContainerBuilderAndFileLocator($containerBuilder, $fileLocator);
    }
    private function createFromContainerBuilderAndFileLocator(\_PhpScoperc98ae2003489\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \_PhpScoperc98ae2003489\Symfony\Component\Config\FileLocator $simpleFileLocator) : \_PhpScoperc98ae2003489\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $loaders = [new \_PhpScoperc98ae2003489\Symfony\Component\Config\Loader\GlobFileLoader($simpleFileLocator), new \Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader($containerBuilder, $simpleFileLocator)];
        $loaderResolver = new \_PhpScoperc98ae2003489\Symfony\Component\Config\Loader\LoaderResolver($loaders);
        return new \_PhpScoperc98ae2003489\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
