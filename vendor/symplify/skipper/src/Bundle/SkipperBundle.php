<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use _PhpScoperea337ed74749\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperea337ed74749\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \_PhpScoperea337ed74749\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperea337ed74749\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
