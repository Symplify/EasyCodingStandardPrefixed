<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoperfa7254c25e18\PhpParser\Node\Arg;
use _PhpScoperfa7254c25e18\PhpParser\Node\Expr\MethodCall;
use _PhpScoperfa7254c25e18\PhpParser\Node\Expr\Variable;
use _PhpScoperfa7254c25e18\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     SomeNamespace\SomeClass: null <---
 */
final class NameOnlyServiceCaseConverter implements \Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoperfa7254c25e18\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $setMethodCall = new \_PhpScoperfa7254c25e18\PhpParser\Node\Expr\MethodCall(new \_PhpScoperfa7254c25e18\PhpParser\Node\Expr\Variable(\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), 'set', [new \_PhpScoperfa7254c25e18\PhpParser\Node\Arg($classConstFetch)]);
        return new \_PhpScoperfa7254c25e18\PhpParser\Node\Stmt\Expression($setMethodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $values === null || $values === [];
    }
}
