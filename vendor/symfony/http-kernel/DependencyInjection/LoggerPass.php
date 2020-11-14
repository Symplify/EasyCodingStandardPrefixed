<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperecb978830f1e\Symfony\Component\HttpKernel\DependencyInjection;

use _PhpScoperecb978830f1e\Psr\Log\LoggerInterface;
use _PhpScoperecb978830f1e\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoperecb978830f1e\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperecb978830f1e\Symfony\Component\HttpKernel\Log\Logger;
/**
 * Registers the default logger if necessary.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class LoggerPass implements \_PhpScoperecb978830f1e\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoperecb978830f1e\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->setAlias(\_PhpScoperecb978830f1e\Psr\Log\LoggerInterface::class, 'logger')->setPublic(\false);
        if ($container->has('logger')) {
            return;
        }
        $container->register('logger', \_PhpScoperecb978830f1e\Symfony\Component\HttpKernel\Log\Logger::class)->setPublic(\false);
    }
}
