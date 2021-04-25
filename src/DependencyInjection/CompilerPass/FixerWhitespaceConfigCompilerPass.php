<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\DependencyInjection\CompilerPass;

use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\WhitespacesFixerConfig;
use _PhpScoper99c9619a6243\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoper99c9619a6243\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper99c9619a6243\Symfony\Component\DependencyInjection\Reference;
final class FixerWhitespaceConfigCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $containerBuilder) : void
    {
        $definitions = $containerBuilder->getDefinitions();
        foreach ($definitions as $definition) {
            if ($definition->getClass() === null) {
                continue;
            }
            if (!\is_a($definition->getClass(), WhitespacesAwareFixerInterface::class, \true)) {
                continue;
            }
            $definition->addMethodCall('setWhitespacesConfig', [new Reference(WhitespacesFixerConfig::class)]);
        }
    }
}
