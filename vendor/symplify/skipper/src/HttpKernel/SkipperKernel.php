<?php

declare (strict_types=1);
namespace Symplify\Skipper\HttpKernel;

use _PhpScopera48d5dbb002d\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScopera48d5dbb002d\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symplify\Skipper\Bundle\SkipperBundle;
use Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SkipperKernel extends AbstractSymplifyKernel
{
    public function registerContainerConfiguration(LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        parent::registerContainerConfiguration($loader);
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new SkipperBundle(), new SymplifyKernelBundle()];
    }
}
