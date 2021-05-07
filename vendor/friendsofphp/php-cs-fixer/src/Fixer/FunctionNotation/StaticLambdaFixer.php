<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Fixer\FunctionNotation;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\Tokenizer\TokensAnalyzer;
/**
 * @author SpacePossum
 */
final class StaticLambdaFixer extends AbstractFixer
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('Lambdas not (indirect) referencing `$this` must be declared `static`.', [new CodeSample("<?php\n\$a = function () use (\$b)\n{   echo \$b;\n};\n")], null, 'Risky when using `->bindTo` on lambdas without referencing to `$this`.');
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        if (\PHP_VERSION_ID >= 70400 && $tokens->isTokenKindFound(\T_FN)) {
            return \true;
        }
        return $tokens->isTokenKindFound(\T_FUNCTION);
    }
    /**
     * {@inheritdoc}
     * @return bool
     */
    public function isRisky()
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        $analyzer = new TokensAnalyzer($tokens);
        $expectedFunctionKinds = [\T_FUNCTION];
        if (\PHP_VERSION_ID >= 70400) {
            $expectedFunctionKinds[] = \T_FN;
        }
        for ($index = $tokens->count() - 4; $index > 0; --$index) {
            if (!$tokens[$index]->isGivenKind($expectedFunctionKinds) || !$analyzer->isLambda($index)) {
                continue;
            }
            $prev = $tokens->getPrevMeaningfulToken($index);
            if ($tokens[$prev]->isGivenKind(\T_STATIC)) {
                continue;
                // lambda is already 'static'
            }
            $argumentsStartIndex = $tokens->getNextTokenOfKind($index, ['(']);
            $argumentsEndIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $argumentsStartIndex);
            // figure out where the lambda starts and ends
            if ($tokens[$index]->isGivenKind(\T_FUNCTION)) {
                $lambdaOpenIndex = $tokens->getNextTokenOfKind($argumentsEndIndex, ['{']);
                $lambdaEndIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_CURLY_BRACE, $lambdaOpenIndex);
            } else {
                // T_FN
                $lambdaOpenIndex = $tokens->getNextTokenOfKind($argumentsEndIndex, [[\T_DOUBLE_ARROW]]);
                $lambdaEndIndex = $this->findExpressionEnd($tokens, $lambdaOpenIndex);
            }
            if ($this->hasPossibleReferenceToThis($tokens, $lambdaOpenIndex, $lambdaEndIndex)) {
                continue;
            }
            // make the lambda static
            $tokens->insertAt($index, [new Token([\T_STATIC, 'static']), new Token([\T_WHITESPACE, ' '])]);
            $index -= 4;
            // fixed after a lambda, closes candidate is at least 4 tokens before that
        }
    }
    /**
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $index
     * @return int
     */
    private function findExpressionEnd($tokens, $index)
    {
        $nextIndex = $tokens->getNextMeaningfulToken($index);
        while (null !== $nextIndex) {
            /** @var Token $nextToken */
            $nextToken = $tokens[$nextIndex];
            if ($nextToken->equalsAny([',', ';', [\T_CLOSE_TAG]])) {
                break;
            }
            /** @var null|array{isStart: bool, type: int} $blockType */
            $blockType = Tokens::detectBlockType($nextToken);
            if (null !== $blockType && $blockType['isStart']) {
                $nextIndex = $tokens->findBlockEnd($blockType['type'], $nextIndex);
            }
            $index = $nextIndex;
            $nextIndex = $tokens->getNextMeaningfulToken($index);
        }
        return $index;
    }
    /**
     * Returns 'true' if there is a possible reference to '$this' within the given tokens index range.
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $startIndex
     * @param int $endIndex
     * @return bool
     */
    private function hasPossibleReferenceToThis($tokens, $startIndex, $endIndex)
    {
        for ($i = $startIndex; $i < $endIndex; ++$i) {
            if ($tokens[$i]->isGivenKind(\T_VARIABLE) && '$this' === \strtolower($tokens[$i]->getContent())) {
                return \true;
                // directly accessing '$this'
            }
            if ($tokens[$i]->isGivenKind([
                \T_INCLUDE,
                // loading additional symbols we cannot analyze here
                \T_INCLUDE_ONCE,
                // "
                \T_REQUIRE,
                // "
                \T_REQUIRE_ONCE,
                // "
                CT::T_DYNAMIC_VAR_BRACE_OPEN,
                // "$h = ${$g};" case
                \T_EVAL,
            ])) {
                return \true;
            }
            if ($tokens[$i]->equals('$')) {
                $nextIndex = $tokens->getNextMeaningfulToken($i);
                if ($tokens[$nextIndex]->isGivenKind(\T_VARIABLE)) {
                    return \true;
                    // "$$a" case
                }
            }
        }
        return \false;
    }
}
