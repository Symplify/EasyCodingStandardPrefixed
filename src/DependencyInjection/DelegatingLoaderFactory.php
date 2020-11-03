<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\DependencyInjection;

use _PhpScopercf327c47dfc5\Symfony\Component\Config\FileLocator as SimpleFileLocator;
use _PhpScopercf327c47dfc5\Symfony\Component\Config\Loader\DelegatingLoader;
use _PhpScopercf327c47dfc5\Symfony\Component\Config\Loader\GlobFileLoader;
use _PhpScopercf327c47dfc5\Symfony\Component\Config\Loader\LoaderResolver;
use _PhpScopercf327c47dfc5\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScopercf327c47dfc5\Symfony\Component\HttpKernel\Config\FileLocator;
use _PhpScopercf327c47dfc5\Symfony\Component\HttpKernel\KernelInterface;
use Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
final class DelegatingLoaderFactory
{
    public function createFromContainerBuilderAndKernel(\_PhpScopercf327c47dfc5\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \_PhpScopercf327c47dfc5\Symfony\Component\HttpKernel\KernelInterface $kernel) : \_PhpScopercf327c47dfc5\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $kernelFileLocator = new \_PhpScopercf327c47dfc5\Symfony\Component\HttpKernel\Config\FileLocator($kernel);
        return $this->createFromContainerBuilderAndFileLocator($containerBuilder, $kernelFileLocator);
    }
    /**
     * For tests
     */
    public function createContainerBuilderAndConfig(\_PhpScopercf327c47dfc5\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $config) : \_PhpScopercf327c47dfc5\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $directory = \dirname($config);
        $fileLocator = new \_PhpScopercf327c47dfc5\Symfony\Component\Config\FileLocator($directory);
        return $this->createFromContainerBuilderAndFileLocator($containerBuilder, $fileLocator);
    }
    private function createFromContainerBuilderAndFileLocator(\_PhpScopercf327c47dfc5\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \_PhpScopercf327c47dfc5\Symfony\Component\Config\FileLocator $simpleFileLocator) : \_PhpScopercf327c47dfc5\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $loaders = [new \_PhpScopercf327c47dfc5\Symfony\Component\Config\Loader\GlobFileLoader($simpleFileLocator), new \Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader($containerBuilder, $simpleFileLocator)];
        $loaderResolver = new \_PhpScopercf327c47dfc5\Symfony\Component\Config\Loader\LoaderResolver($loaders);
        return new \_PhpScopercf327c47dfc5\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
