<?php

declare (strict_types=1);
namespace _PhpScoperd4937ee9b515\Migrify\PhpConfigPrinter\RoutingCaseConverter;

use _PhpScoperd4937ee9b515\Migrify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use _PhpScoperd4937ee9b515\Migrify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use _PhpScoperd4937ee9b515\Migrify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoperd4937ee9b515\PhpParser\Node\Arg;
use _PhpScoperd4937ee9b515\PhpParser\Node\Expr\MethodCall;
use _PhpScoperd4937ee9b515\PhpParser\Node\Expr\Variable;
use _PhpScoperd4937ee9b515\PhpParser\Node\Stmt\Expression;
final class PathRoutingCaseConverter implements \_PhpScoperd4937ee9b515\Migrify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface
{
    /**
     * @var string[]
     */
    private const NESTED_KEYS = ['controller', 'defaults', self::METHODS, 'requirements'];
    /**
     * @var string
     */
    private const PATH = 'path';
    /**
     * @var string
     */
    private const METHODS = 'methods';
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\_PhpScoperd4937ee9b515\Migrify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    public function match(string $key, $values) : bool
    {
        return isset($values[self::PATH]);
    }
    public function convertToMethodCall(string $key, $values) : \_PhpScoperd4937ee9b515\PhpParser\Node\Stmt\Expression
    {
        $variable = new \_PhpScoperd4937ee9b515\PhpParser\Node\Expr\Variable(\_PhpScoperd4937ee9b515\Migrify\PhpConfigPrinter\ValueObject\VariableName::ROUTING_CONFIGURATOR);
        // @todo args
        $args = $this->createAddArgs($key, $values);
        $methodCall = new \_PhpScoperd4937ee9b515\PhpParser\Node\Expr\MethodCall($variable, 'add', $args);
        foreach (self::NESTED_KEYS as $nestedKey) {
            if (!isset($values[$nestedKey])) {
                continue;
            }
            $nestedValues = $values[$nestedKey];
            // Transform methods as string GET|HEAD to array
            if ($nestedKey === self::METHODS && \is_string($nestedValues)) {
                $nestedValues = \explode('|', $nestedValues);
            }
            $args = $this->argsNodeFactory->createFromValues([$nestedValues]);
            $methodCall = new \_PhpScoperd4937ee9b515\PhpParser\Node\Expr\MethodCall($methodCall, $nestedKey, $args);
        }
        return new \_PhpScoperd4937ee9b515\PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @param mixed $values
     * @return Arg[]
     */
    private function createAddArgs(string $key, $values) : array
    {
        $argumentValues = [];
        $argumentValues[] = $key;
        if (isset($values[self::PATH])) {
            $argumentValues[] = $values[self::PATH];
        }
        return $this->argsNodeFactory->createFromValues($argumentValues);
    }
}
