<?php

declare (strict_types=1);
namespace _PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\NodeFactory\Service;

use _PhpScoperb6d4bd368bd9\Migrify\ConfigTransformer\ValueObject\SymfonyVersionFeature;
use _PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use _PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory;
use _PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use _PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use _PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey;
use _PhpScoperb6d4bd368bd9\PhpParser\Node\Arg;
use _PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall;
final class AutoBindNodeFactory
{
    /**
     * @var string
     */
    public const TYPE_SERVICE = 'service';
    /**
     * @var string
     */
    public const TYPE_DEFAULTS = 'defaults';
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var SymfonyVersionFeatureGuardInterface
     */
    private $symfonyVersionFeatureGuard;
    /**
     * @var TagsServiceOptionKeyYamlToPhpFactory
     */
    private $tagsServiceOptionKeyYamlToPhpFactory;
    public function __construct(\_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface $symfonyVersionFeatureGuard, \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory $tagsServiceOptionKeyYamlToPhpFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->symfonyVersionFeatureGuard = $symfonyVersionFeatureGuard;
        $this->tagsServiceOptionKeyYamlToPhpFactory = $tagsServiceOptionKeyYamlToPhpFactory;
    }
    /**
     * Decorated node with:
     * ->autowire()
     * ->autoconfigure()
     * ->bind()
     */
    public function createAutoBindCalls(array $yaml, \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall
    {
        foreach ($yaml as $key => $value) {
            if ($key === \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE) {
                $methodCall = $this->createAutowire($value, $methodCall, $type);
            }
            if ($key === \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE) {
                $methodCall = $this->createAutoconfigure($value, $methodCall, $type);
            }
            if ($key === \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey::PUBLIC) {
                $methodCall = $this->createPublicPrivate($value, $methodCall, $type);
            }
            if ($key === \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey::BIND) {
                $methodCall = $this->createBindMethodCall($methodCall, $yaml[\_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey::BIND]);
            }
            if ($key === \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey::TAGS) {
                $methodCall = $this->createTagsMethodCall($methodCall, $value);
            }
        }
        return $methodCall;
    }
    private function createBindMethodCall(\_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall $methodCall, array $bindValues) : \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall
    {
        foreach ($bindValues as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value]);
            $methodCall = new \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall($methodCall, \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey::BIND, $args);
        }
        return $methodCall;
    }
    private function createAutowire($value, \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall
    {
        if ($value === \true) {
            return new \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall($methodCall, \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE);
        }
        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new \_PhpScoperb6d4bd368bd9\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall($methodCall, \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE, $args);
    }
    private function createAutoconfigure($value, \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall $methodCall, string $type)
    {
        if ($value === \true) {
            return new \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall($methodCall, \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE);
        }
        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new \_PhpScoperb6d4bd368bd9\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall($methodCall, \_PhpScoperb6d4bd368bd9\Migrify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE, $args);
    }
    private function createPublicPrivate($value, \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall
    {
        if ($value !== \false) {
            return new \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall($methodCall, 'public');
        }
        // default value
        if ($type === self::TYPE_DEFAULTS) {
            if ($this->symfonyVersionFeatureGuard->isAtLeastSymfonyVersion(\_PhpScoperb6d4bd368bd9\Migrify\ConfigTransformer\ValueObject\SymfonyVersionFeature::PRIVATE_SERVICES_BY_DEFAULT)) {
                return $methodCall;
            }
            return new \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall($methodCall, 'private');
        }
        $args = [new \_PhpScoperb6d4bd368bd9\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall($methodCall, 'public', $args);
    }
    private function createTagsMethodCall(\_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall $methodCall, $value) : \_PhpScoperb6d4bd368bd9\PhpParser\Node\Expr\MethodCall
    {
        return $this->tagsServiceOptionKeyYamlToPhpFactory->decorateServiceMethodCall(null, $value, [], $methodCall);
    }
}
