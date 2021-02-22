<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfcee700af3df\Symfony\Component\DependencyInjection\Compiler;

trigger_deprecation('symfony/dependency-injection', '5.2', 'The "%s" class is deprecated.', \_PhpScoperfcee700af3df\Symfony\Component\DependencyInjection\Compiler\ResolvePrivatesPass::class);
use _PhpScoperfcee700af3df\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @deprecated since Symfony 5.2
 */
class ResolvePrivatesPass implements \_PhpScoperfcee700af3df\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoperfcee700af3df\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        foreach ($container->getDefinitions() as $id => $definition) {
            if ($definition->isPrivate()) {
                $definition->setPublic(\false);
                $definition->setPrivate(\true);
            }
        }
        foreach ($container->getAliases() as $id => $alias) {
            if ($alias->isPrivate()) {
                $alias->setPublic(\false);
                $alias->setPrivate(\true);
            }
        }
    }
}
