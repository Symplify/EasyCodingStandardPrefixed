<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfcee700af3df\Symfony\Component\HttpKernel\DependencyInjection;

use _PhpScoperfcee700af3df\Psr\Log\LoggerInterface;
use _PhpScoperfcee700af3df\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoperfcee700af3df\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperfcee700af3df\Symfony\Component\HttpKernel\Log\Logger;
/**
 * Registers the default logger if necessary.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class LoggerPass implements \_PhpScoperfcee700af3df\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoperfcee700af3df\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->setAlias(\_PhpScoperfcee700af3df\Psr\Log\LoggerInterface::class, 'logger')->setPublic(\false);
        if ($container->has('logger')) {
            return;
        }
        $container->register('logger', \_PhpScoperfcee700af3df\Symfony\Component\HttpKernel\Log\Logger::class)->setPublic(\false);
    }
}
