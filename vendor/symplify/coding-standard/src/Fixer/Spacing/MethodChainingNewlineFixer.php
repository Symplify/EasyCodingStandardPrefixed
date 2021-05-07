<?php

namespace Symplify\CodingStandard\Fixer\Spacing;

use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\WhitespacesFixerConfig;
use SplFileInfo;
use Symplify\CodingStandard\Fixer\AbstractSymplifyFixer;
use Symplify\CodingStandard\TokenAnalyzer\ChainMethodCallAnalyzer;
use Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\BlockFinder;
use Symplify\CodingStandard\TokenRunner\ValueObject\BlockInfo;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Symplify\CodingStandard\Tests\Fixer\Spacing\MethodChainingNewlineFixer\MethodChainingNewlineFixerTest
 */
final class MethodChainingNewlineFixer extends AbstractSymplifyFixer implements DocumentedRuleInterface
{
    /**
     * @var string
     */
    const ERROR_MESSAGE = 'Each chain method call must be on own line';
    /**
     * @var WhitespacesFixerConfig
     */
    private $whitespacesFixerConfig;
    /**
     * @var BlockFinder
     */
    private $blockFinder;
    /**
     * @var ChainMethodCallAnalyzer
     */
    private $chainMethodCallAnalyzer;
    /**
     * @param \PhpCsFixer\WhitespacesFixerConfig $whitespacesFixerConfig
     * @param \Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\BlockFinder $blockFinder
     * @param \Symplify\CodingStandard\TokenAnalyzer\ChainMethodCallAnalyzer $chainMethodCallAnalyzer
     */
    public function __construct($whitespacesFixerConfig, $blockFinder, $chainMethodCallAnalyzer)
    {
        $this->whitespacesFixerConfig = $whitespacesFixerConfig;
        $this->blockFinder = $blockFinder;
        $this->chainMethodCallAnalyzer = $chainMethodCallAnalyzer;
    }
    /**
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition(self::ERROR_MESSAGE, []);
    }
    /**
     * Must run before
     *
     * @see \PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer::getPriority()
     * @return int
     */
    public function getPriority()
    {
        return 39;
    }
    /**
     * @param Tokens<Token> $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isAnyTokenKindsFound([\T_OBJECT_OPERATOR]);
    }
    /**
     * @param Tokens<Token> $tokens
     * @return void
     * @param \SplFileInfo $file
     */
    public function fix($file, $tokens)
    {
        // function arguments, function call parameters, lambda use()
        for ($index = 1, $count = \count($tokens); $index < $count; ++$index) {
            $currentToken = $tokens[$index];
            if (!$currentToken->isGivenKind(\T_OBJECT_OPERATOR)) {
                continue;
            }
            if (!$this->shouldPrefixNewline($tokens, $index)) {
                continue;
            }
            $tokens->ensureWhitespaceAtIndex($index, 0, $this->whitespacesFixerConfig->getLineEnding());
            ++$index;
        }
    }
    /**
     * @return \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
     */
    public function getRuleDefinition()
    {
        return new RuleDefinition(self::ERROR_MESSAGE, [new CodeSample(<<<'CODE_SAMPLE'
$someClass->firstCall()->secondCall();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someClass->firstCall()
->secondCall();
CODE_SAMPLE
)]);
    }
    /**
     * @param Tokens<Token> $tokens
     * @param int $objectOperatorIndex
     * @return bool
     */
    private function shouldPrefixNewline($tokens, $objectOperatorIndex)
    {
        for ($i = $objectOperatorIndex; $i >= 0; --$i) {
            /** @var Token $currentToken */
            $currentToken = $tokens[$i];
            if ($currentToken->equals(')')) {
                return $this->shouldBracketPrefix($tokens, $i, $objectOperatorIndex);
            }
            if ($currentToken->isGivenKind([\T_NEW, \T_VARIABLE])) {
                return \false;
            }
            if ($currentToken->getContent() === '(') {
                return \false;
            }
        }
        return \false;
    }
    /**
     * @param Tokens<Token> $tokens
     * @param int $position
     * @return bool
     */
    private function isDoubleBracket($tokens, $position)
    {
        /** @var int $nextTokenPosition */
        $nextTokenPosition = $tokens->getNextNonWhitespace($position);
        /** @var Token $nextToken */
        $nextToken = $tokens[$nextTokenPosition];
        return $nextToken->getContent() === ')';
    }
    /**
     * Matches e.g.: - app([ ])->some()
     *
     * @param Tokens<Token> $tokens
     * @param int $position
     * @return bool
     */
    private function isPreceededByOpenedCallInAnotherBracket($tokens, $position)
    {
        $blockInfo = $this->blockFinder->findInTokensByEdge($tokens, $position);
        if (!$blockInfo instanceof BlockInfo) {
            return \false;
        }
        return $tokens->isPartialCodeMultiline($blockInfo->getStart(), $blockInfo->getEnd());
    }
    /**
     * @param Tokens<Token> $tokens
     * @param int $position
     * @param int $objectOperatorIndex
     * @return bool
     */
    private function shouldBracketPrefix($tokens, $position, $objectOperatorIndex)
    {
        if ($this->isDoubleBracket($tokens, $position)) {
            return \false;
        }
        if ($this->chainMethodCallAnalyzer->isPartOfMethodCallOrArray($tokens, $position)) {
            return \false;
        }
        if ($this->chainMethodCallAnalyzer->isPreceededByFuncCall($tokens, $position)) {
            return \false;
        }
        if ($this->isPreceededByOpenedCallInAnotherBracket($tokens, $position)) {
            return \false;
        }
        // all good, there is a newline
        return !$tokens->isPartialCodeMultiline($position, $objectOperatorIndex);
    }
}
