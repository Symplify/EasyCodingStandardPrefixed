<?php

declare (strict_types=1);
namespace _PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\CaseConverter;

use _PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\Contract\NestedCaseConverterInterface;
use _PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use _PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use _PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\ValueObject\YamlKey;
use _PhpScoperd9c3b46af121\PhpParser\Node\Arg;
use _PhpScoperd9c3b46af121\PhpParser\Node\Expr\MethodCall;
use _PhpScoperd9c3b46af121\PhpParser\Node\Expr\Variable;
use _PhpScoperd9c3b46af121\PhpParser\Node\Stmt\Expression;
/**
 * Handles this part:
 *
 * services:
 *     _instanceof: <---
 */
final class InstanceOfNestedCaseConverter implements \_PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\Contract\NestedCaseConverterInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\_PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \_PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoperd9c3b46af121\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $servicesVariable = new \_PhpScoperd9c3b46af121\PhpParser\Node\Expr\Variable(\_PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        $args = [new \_PhpScoperd9c3b46af121\PhpParser\Node\Arg($classConstFetch)];
        $instanceofMethodCall = new \_PhpScoperd9c3b46af121\PhpParser\Node\Expr\MethodCall($servicesVariable, \_PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\ValueObject\MethodName::INSTANCEOF, $args);
        $instanceofMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $instanceofMethodCall);
        $expression = new \_PhpScoperd9c3b46af121\PhpParser\Node\Stmt\Expression($instanceofMethodCall);
        $expression->setAttribute('comments', $instanceofMethodCall->getComments());
        return $expression;
    }
    public function match(string $rootKey, $subKey) : bool
    {
        if ($rootKey !== \_PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (!\is_string($subKey)) {
            return \false;
        }
        return $subKey === \_PhpScoperd9c3b46af121\Migrify\PhpConfigPrinter\ValueObject\YamlKey::_INSTANCEOF;
    }
}
