<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use _PhpScoper9d73a84b09ad\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoper9d73a84b09ad\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \_PhpScoper9d73a84b09ad\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoper9d73a84b09ad\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
