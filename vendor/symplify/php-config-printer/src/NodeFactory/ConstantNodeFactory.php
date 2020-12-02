<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory;

use _PhpScopera34ae19e8d40\Nette\Utils\Strings;
use _PhpScopera34ae19e8d40\PhpParser\Node\Expr;
use _PhpScopera34ae19e8d40\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopera34ae19e8d40\PhpParser\Node\Expr\ConstFetch;
use _PhpScopera34ae19e8d40\PhpParser\Node\Name;
use _PhpScopera34ae19e8d40\PhpParser\Node\Name\FullyQualified;
use Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
/**
 * Hacking constants @solve better in the future
 * now it's hardcoded very deep in yaml parser, so unable to detected: https://github.com/symfony/symfony/blob/ba4d57bb5fc0e9a1b4f63ced66156296dea3687e/src/Symfony/Component/Yaml/Inline.php#L617
 * @see https://github.com/symfony/symfony/pull/18626/files
 */
final class ConstantNodeFactory
{
    /**
     * @var YamlFileContentProviderInterface
     */
    private $yamlFileContentProvider;
    public function __construct(\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface $yamlFileContentProvider)
    {
        $this->yamlFileContentProvider = $yamlFileContentProvider;
    }
    /**
     * @return ConstFetch|ClassConstFetch|null
     */
    public function createConstantIfValue(string $value) : ?\_PhpScopera34ae19e8d40\PhpParser\Node\Expr
    {
        if (\_PhpScopera34ae19e8d40\Nette\Utils\Strings::contains($value, '::')) {
            [$class, $constant] = \explode('::', $value);
            // not uppercase → probably not a constant
            if (\strtoupper($constant) !== $constant) {
                return null;
            }
            return new \_PhpScopera34ae19e8d40\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScopera34ae19e8d40\PhpParser\Node\Name\FullyQualified($class), $constant);
        }
        $definedConstants = \get_defined_constants();
        foreach (\array_keys($definedConstants) as $constantName) {
            if ($value !== \constant($constantName)) {
                continue;
            }
            $yamlContent = $this->yamlFileContentProvider->getYamlContent();
            $constantDefinitionPattern = '#' . \preg_quote('!php/const', '#') . '(\\s)+' . $constantName . '#';
            if (!\_PhpScopera34ae19e8d40\Nette\Utils\Strings::match($yamlContent, $constantDefinitionPattern)) {
                continue;
            }
            return new \_PhpScopera34ae19e8d40\PhpParser\Node\Expr\ConstFetch(new \_PhpScopera34ae19e8d40\PhpParser\Node\Name($constantName));
        }
        return null;
    }
}
