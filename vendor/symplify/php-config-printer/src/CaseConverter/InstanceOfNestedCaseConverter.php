<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoper59da9ac954a6\PhpParser\Node\Arg;
use _PhpScoper59da9ac954a6\PhpParser\Node\Expr\MethodCall;
use _PhpScoper59da9ac954a6\PhpParser\Node\Expr\Variable;
use _PhpScoper59da9ac954a6\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\NestedCaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\MethodName;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     _instanceof: <---
 */
final class InstanceOfNestedCaseConverter implements \Symplify\PhpConfigPrinter\Contract\NestedCaseConverterInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoper59da9ac954a6\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $servicesVariable = new \_PhpScoper59da9ac954a6\PhpParser\Node\Expr\Variable(\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        $args = [new \_PhpScoper59da9ac954a6\PhpParser\Node\Arg($classConstFetch)];
        $instanceofMethodCall = new \_PhpScoper59da9ac954a6\PhpParser\Node\Expr\MethodCall($servicesVariable, \Symplify\PhpConfigPrinter\ValueObject\MethodName::INSTANCEOF, $args);
        $instanceofMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $instanceofMethodCall);
        return new \_PhpScoper59da9ac954a6\PhpParser\Node\Stmt\Expression($instanceofMethodCall);
    }
    public function match(string $rootKey, $subKey) : bool
    {
        if ($rootKey !== \Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (!\is_string($subKey)) {
            return \false;
        }
        return $subKey === \Symplify\PhpConfigPrinter\ValueObject\YamlKey::_INSTANCEOF;
    }
}
