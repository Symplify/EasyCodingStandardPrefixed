<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfb2c402b972b\Symfony\Component\HttpKernel\DependencyInjection;

use _PhpScoperfb2c402b972b\Psr\Log\LoggerInterface;
use _PhpScoperfb2c402b972b\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoperfb2c402b972b\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperfb2c402b972b\Symfony\Component\HttpKernel\Log\Logger;
/**
 * Registers the default logger if necessary.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class LoggerPass implements \_PhpScoperfb2c402b972b\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoperfb2c402b972b\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->setAlias(\_PhpScoperfb2c402b972b\Psr\Log\LoggerInterface::class, 'logger')->setPublic(\false);
        if ($container->has('logger')) {
            return;
        }
        $container->register('logger', \_PhpScoperfb2c402b972b\Symfony\Component\HttpKernel\Log\Logger::class)->setPublic(\false);
    }
}
