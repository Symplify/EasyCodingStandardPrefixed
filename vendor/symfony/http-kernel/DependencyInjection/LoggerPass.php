<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopercd2fc5ef50ef\Symfony\Component\HttpKernel\DependencyInjection;

use _PhpScopercd2fc5ef50ef\Psr\Log\LoggerInterface;
use _PhpScopercd2fc5ef50ef\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScopercd2fc5ef50ef\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScopercd2fc5ef50ef\Symfony\Component\HttpKernel\Log\Logger;
/**
 * Registers the default logger if necessary.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class LoggerPass implements \_PhpScopercd2fc5ef50ef\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScopercd2fc5ef50ef\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->setAlias(\_PhpScopercd2fc5ef50ef\Psr\Log\LoggerInterface::class, 'logger')->setPublic(\false);
        if ($container->has('logger')) {
            return;
        }
        $container->register('logger', \_PhpScopercd2fc5ef50ef\Symfony\Component\HttpKernel\Log\Logger::class)->setPublic(\false);
    }
}
