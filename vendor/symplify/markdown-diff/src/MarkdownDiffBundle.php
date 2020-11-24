<?php

declare (strict_types=1);
namespace Symplify\MarkdownDiff;

use _PhpScoperf3d5f0921050\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperf3d5f0921050\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension;
final class MarkdownDiffBundle extends \_PhpScoperf3d5f0921050\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperf3d5f0921050\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension();
    }
}
