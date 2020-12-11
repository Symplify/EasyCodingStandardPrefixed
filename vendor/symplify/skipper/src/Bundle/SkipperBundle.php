<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use _PhpScoperb26833cc184d\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperb26833cc184d\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \_PhpScoperb26833cc184d\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperb26833cc184d\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
