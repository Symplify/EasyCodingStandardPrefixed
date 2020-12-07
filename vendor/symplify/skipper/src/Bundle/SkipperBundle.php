<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use _PhpScoperda2604e33acb\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperda2604e33acb\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \_PhpScoperda2604e33acb\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperda2604e33acb\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
