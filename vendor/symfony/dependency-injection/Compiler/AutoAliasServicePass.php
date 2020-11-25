<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperaac5f7c652e4\Symfony\Component\DependencyInjection\Compiler;

use _PhpScoperaac5f7c652e4\Symfony\Component\DependencyInjection\Alias;
use _PhpScoperaac5f7c652e4\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperaac5f7c652e4\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
/**
 * Sets a service to be an alias of another one, given a format pattern.
 */
class AutoAliasServicePass implements \_PhpScoperaac5f7c652e4\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoperaac5f7c652e4\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('auto_alias') as $serviceId => $tags) {
            foreach ($tags as $tag) {
                if (!isset($tag['format'])) {
                    throw new \_PhpScoperaac5f7c652e4\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Missing tag information "format" on auto_alias service "%s".', $serviceId));
                }
                $aliasId = $container->getParameterBag()->resolveValue($tag['format']);
                if ($container->hasDefinition($aliasId) || $container->hasAlias($aliasId)) {
                    $container->setAlias($serviceId, new \_PhpScoperaac5f7c652e4\Symfony\Component\DependencyInjection\Alias($aliasId, \true));
                }
            }
        }
    }
}
