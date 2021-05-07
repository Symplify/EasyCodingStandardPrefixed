<?php

namespace Symplify\CodingStandard\Fixer\Naming;

use ECSPrefix20210507\Nette\Utils\Strings;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Symplify\CodingStandard\Fixer\AbstractSymplifyFixer;
use Symplify\RuleDocGenerator\Contract\ConfigurableRuleInterface;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
/**
 * @see \Symplify\CodingStandard\Tests\Fixer\Naming\StandardizeHereNowDocKeywordFixer\StandardizeHereNowDocKeywordFixerTest
 */
final class StandardizeHereNowDocKeywordFixer extends AbstractSymplifyFixer implements ConfigurableRuleInterface, DocumentedRuleInterface, ConfigurableFixerInterface
{
    /**
     * @api
     * @var string
     */
    const KEYWORD = 'keyword';
    /**
     * @var string
     */
    const ERROR_MESSAGE = 'Use configured nowdoc and heredoc keyword';
    /**
     * @api
     * @var string
     */
    const DEFAULT_KEYWORD = 'CODE_SAMPLE';
    /**
     * @see https://regex101.com/r/ED2b9V/1
     * @var string
     */
    const START_HEREDOC_NOWDOC_NAME_REGEX = '#(<<<(\')?)(?<name>.*?)((\')?\\s)#';
    /**
     * @var string
     */
    private $keyword = self::DEFAULT_KEYWORD;
    /**
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition(self::ERROR_MESSAGE, []);
    }
    /**
     * @param Tokens<Token> $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isAnyTokenKindsFound([\T_START_HEREDOC, T_START_NOWDOC]);
    }
    /**
     * @param Tokens<Token> $tokens
     * @return void
     * @param \SplFileInfo $file
     */
    public function fix($file, $tokens)
    {
        // function arguments, function call parameters, lambda use()
        for ($position = \count($tokens) - 1; $position >= 0; --$position) {
            /** @var Token $token */
            $token = $tokens[$position];
            if ($token->isGivenKind(\T_START_HEREDOC)) {
                $this->fixStartToken($tokens, $token, $position);
            }
            if ($token->isGivenKind(\T_END_HEREDOC)) {
                $this->fixEndToken($tokens, $token, $position);
            }
        }
    }
    /**
     * @return \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
     */
    public function getRuleDefinition()
    {
        return new RuleDefinition(self::ERROR_MESSAGE, [new ConfiguredCodeSample(<<<'CODE_SAMPLE'
$value = <<<'WHATEVER'
...
'WHATEVER'
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$value = <<<'CODE_SNIPPET'
...
'CODE_SNIPPET'
CODE_SAMPLE
, [self::KEYWORD => 'CODE_SNIPPET'])]);
    }
    /**
     * @param mixed[]|null $configuration
     * @return void
     */
    public function configure($configuration = null)
    {
        $this->keyword = isset($configuration[self::KEYWORD]) ? $configuration[self::KEYWORD] : self::DEFAULT_KEYWORD;
    }
    /**
     * @return \PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface
     */
    public function getConfigurationDefinition()
    {
        throw new ShouldNotHappenException();
    }
    /**
     * @param Tokens<Token> $tokens
     * @return void
     * @param \PhpCsFixer\Tokenizer\Token $token
     * @param int $position
     */
    private function fixStartToken($tokens, $token, $position)
    {
        $match = Strings::match($token->getContent(), self::START_HEREDOC_NOWDOC_NAME_REGEX);
        if (!isset($match['name'])) {
            return;
        }
        $newContent = Strings::replace($token->getContent(), self::START_HEREDOC_NOWDOC_NAME_REGEX, '$1' . $this->keyword . '$4');
        $tokens[$position] = new Token([$token->getId(), $newContent]);
    }
    /**
     * @param Tokens<Token> $tokens
     * @return void
     * @param \PhpCsFixer\Tokenizer\Token $token
     * @param int $position
     */
    private function fixEndToken($tokens, $token, $position)
    {
        if ($token->getContent() === $this->keyword) {
            return;
        }
        $tokenContent = $token->getContent();
        $trimmedTokenContent = \trim($tokenContent);
        $spaceEnd = '';
        if (\PHP_VERSION_ID >= 70300 && $tokenContent !== $trimmedTokenContent) {
            $spaceEnd = \substr($tokenContent, 0, \strlen($tokenContent) - \strlen($trimmedTokenContent));
        }
        $tokens[$position] = new Token([$token->getId(), $spaceEnd . $this->keyword]);
    }
}
