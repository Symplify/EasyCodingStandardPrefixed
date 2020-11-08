<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\FixerRunner;

use PhpCsFixer\WhitespacesFixerConfig;
use Symplify\EasyCodingStandard\Exception\Configuration\WhitespaceConfigurationException;
use Symplify\EasyCodingStandard\FixerRunner\ValueObject\Spacing;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
final class WhitespacesFixerConfigFactory
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function create() : \PhpCsFixer\WhitespacesFixerConfig
    {
        $lineEnding = $this->parameterProvider->provideParameter('line_ending');
        if ($lineEnding === '\\n') {
            $lineEnding = "\n";
        }
        return new \PhpCsFixer\WhitespacesFixerConfig($this->resolveIndentation(), $lineEnding);
    }
    private function resolveIndentation() : string
    {
        $indentation = $this->parameterProvider->provideParameter('indentation');
        if ($indentation === 'tab' || $indentation === \Symplify\EasyCodingStandard\FixerRunner\ValueObject\Spacing::ONE_TAB) {
            return \Symplify\EasyCodingStandard\FixerRunner\ValueObject\Spacing::ONE_TAB;
        }
        if ($indentation === \Symplify\EasyCodingStandard\FixerRunner\ValueObject\Spacing::TWO_SPACES) {
            return \Symplify\EasyCodingStandard\FixerRunner\ValueObject\Spacing::TWO_SPACES;
        }
        if ($indentation === 'spaces' || $indentation === \Symplify\EasyCodingStandard\FixerRunner\ValueObject\Spacing::FOUR_SPACES) {
            return \Symplify\EasyCodingStandard\FixerRunner\ValueObject\Spacing::FOUR_SPACES;
        }
        $allowedValues = ['tab', 'spaces', \Symplify\EasyCodingStandard\FixerRunner\ValueObject\Spacing::TWO_SPACES, \Symplify\EasyCodingStandard\FixerRunner\ValueObject\Spacing::FOUR_SPACES, \Symplify\EasyCodingStandard\FixerRunner\ValueObject\Spacing::ONE_TAB];
        throw new \Symplify\EasyCodingStandard\Exception\Configuration\WhitespaceConfigurationException(\sprintf('Value "%s" is not supported in "parameters > indentation".%sUse one of: "%s".', $indentation, \PHP_EOL, \implode('", "', $allowedValues)));
    }
}
