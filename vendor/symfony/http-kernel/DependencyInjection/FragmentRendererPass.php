<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopera48d5dbb002d\Symfony\Component\HttpKernel\DependencyInjection;

use _PhpScopera48d5dbb002d\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScopera48d5dbb002d\Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use _PhpScopera48d5dbb002d\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScopera48d5dbb002d\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use _PhpScopera48d5dbb002d\Symfony\Component\DependencyInjection\Reference;
use _PhpScopera48d5dbb002d\Symfony\Component\HttpKernel\Fragment\FragmentRendererInterface;
/**
 * Adds services tagged kernel.fragment_renderer as HTTP content rendering strategies.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class FragmentRendererPass implements CompilerPassInterface
{
    private $handlerService;
    private $rendererTag;
    public function __construct(string $handlerService = 'fragment.handler', string $rendererTag = 'kernel.fragment_renderer')
    {
        $this->handlerService = $handlerService;
        $this->rendererTag = $rendererTag;
    }
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->handlerService)) {
            return;
        }
        $definition = $container->getDefinition($this->handlerService);
        $renderers = [];
        foreach ($container->findTaggedServiceIds($this->rendererTag, \true) as $id => $tags) {
            $def = $container->getDefinition($id);
            $class = $container->getParameterBag()->resolveValue($def->getClass());
            if (!($r = $container->getReflectionClass($class))) {
                throw new InvalidArgumentException(\sprintf('Class "%s" used for service "%s" cannot be found.', $class, $id));
            }
            if (!$r->isSubclassOf(FragmentRendererInterface::class)) {
                throw new InvalidArgumentException(\sprintf('Service "%s" must implement interface "%s".', $id, FragmentRendererInterface::class));
            }
            foreach ($tags as $tag) {
                $renderers[$tag['alias']] = new Reference($id);
            }
        }
        $definition->replaceArgument(0, ServiceLocatorTagPass::register($container, $renderers));
    }
}
