<?php

declare (strict_types=1);
namespace Symplify\AutowireArrayParameter\Skipper;

use ReflectionMethod;
use ReflectionParameter;
use _PhpScoper27cac5a8b4ab\Symfony\Component\DependencyInjection\Definition;
use Symplify\AutowireArrayParameter\TypeResolver\ParameterTypeResolver;
final class ParameterSkipper
{
    /**
     * Classes that create circular dependencies
     *
     * @var string[]
     * @noRector
     */
    private const DEFAULT_EXCLUDED_FATAL_CLASSES = ['_PhpScoper27cac5a8b4ab\\Symfony\\Component\\Form\\FormExtensionInterface', '_PhpScoper27cac5a8b4ab\\Symfony\\Component\\Asset\\PackageInterface', '_PhpScoper27cac5a8b4ab\\Symfony\\Component\\Config\\Loader\\LoaderInterface', '_PhpScoper27cac5a8b4ab\\Symfony\\Component\\VarDumper\\Dumper\\ContextProvider\\ContextProviderInterface', '_PhpScoper27cac5a8b4ab\\EasyCorp\\Bundle\\EasyAdminBundle\\Form\\Type\\Configurator\\TypeConfiguratorInterface', '_PhpScoper27cac5a8b4ab\\Sonata\\CoreBundle\\Model\\Adapter\\AdapterInterface', '_PhpScoper27cac5a8b4ab\\Sonata\\Doctrine\\Adapter\\AdapterChain', '_PhpScoper27cac5a8b4ab\\Sonata\\Twig\\Extension\\TemplateExtension'];
    /**
     * @var ParameterTypeResolver
     */
    private $parameterTypeResolver;
    /**
     * @var string[]
     */
    private $excludedFatalClasses = [];
    /**
     * @param string[] $excludedFatalClasses
     */
    public function __construct(ParameterTypeResolver $parameterTypeResolver, array $excludedFatalClasses)
    {
        $this->parameterTypeResolver = $parameterTypeResolver;
        $this->excludedFatalClasses = \array_merge(self::DEFAULT_EXCLUDED_FATAL_CLASSES, $excludedFatalClasses);
    }
    public function shouldSkipParameter(ReflectionMethod $reflectionMethod, Definition $definition, ReflectionParameter $reflectionParameter) : bool
    {
        if (!$this->isArrayType($reflectionParameter)) {
            return \true;
        }
        // already set
        $argumentName = '$' . $reflectionParameter->getName();
        if (isset($definition->getArguments()[$argumentName])) {
            return \true;
        }
        $parameterType = $this->parameterTypeResolver->resolveParameterType($reflectionParameter->getName(), $reflectionMethod);
        if ($parameterType === null) {
            return \true;
        }
        if (\in_array($parameterType, $this->excludedFatalClasses, \true)) {
            return \true;
        }
        if (!\class_exists($parameterType) && !\interface_exists($parameterType)) {
            return \true;
        }
        // prevent circular dependency
        if ($definition->getClass() === null) {
            return \false;
        }
        return \is_a($definition->getClass(), $parameterType, \true);
    }
    private function isArrayType(ReflectionParameter $reflectionParameter) : bool
    {
        if ($reflectionParameter->getType() === null) {
            return \false;
        }
        $reflectionParameterType = $reflectionParameter->getType();
        return $reflectionParameterType->getName() === 'array';
    }
}
