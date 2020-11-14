<?php

declare (strict_types=1);
namespace Symplify\Skipper\HttpKernel;

use _PhpScoperecb978830f1e\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoperecb978830f1e\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symplify\Skipper\Bundle\SkipperBundle;
use Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SkipperKernel extends \Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\_PhpScoperecb978830f1e\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        parent::registerContainerConfiguration($loader);
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \Symplify\Skipper\Bundle\SkipperBundle(), new \Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
}
