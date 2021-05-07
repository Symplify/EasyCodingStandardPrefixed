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
namespace PhpCsFixer\Fixer\Operator;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Analyzer\Analysis\CaseAnalysis;
use PhpCsFixer\Tokenizer\Analyzer\GotoLabelAnalyzer;
use PhpCsFixer\Tokenizer\Analyzer\SwitchAnalyzer;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class TernaryOperatorSpacesFixer extends AbstractFixer
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('Standardize spaces around ternary operator.', [new CodeSample("<?php \$a = \$a   ?1 :0;\n")]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run after ArraySyntaxFixer, ListSyntaxFixer, TernaryToElvisOperatorFixer.
     * @return int
     */
    public function getPriority()
    {
        return 0;
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isAllTokenKindsFound(['?', ':']);
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        $gotoLabelAnalyzer = new GotoLabelAnalyzer();
        $ternaryOperatorIndices = [];
        $excludedIndices = [];
        foreach ($tokens as $index => $token) {
            if ($token->isGivenKind(\T_SWITCH)) {
                $excludedIndices = \array_merge($excludedIndices, $this->getColonIndicesForSwitch($tokens, $index));
                continue;
            }
            if (!$token->equalsAny(['?', ':'])) {
                continue;
            }
            if (\in_array($index, $excludedIndices, \true)) {
                continue;
            }
            if ($this->belongsToAlternativeSyntax($tokens, $index)) {
                continue;
            }
            if ($gotoLabelAnalyzer->belongsToGoToLabel($tokens, $index)) {
                continue;
            }
            $ternaryOperatorIndices[] = $index;
        }
        foreach (\array_reverse($ternaryOperatorIndices) as $index) {
            $token = $tokens[$index];
            if ($token->equals('?')) {
                $nextNonWhitespaceIndex = $tokens->getNextNonWhitespace($index);
                if ($tokens[$nextNonWhitespaceIndex]->equals(':')) {
                    // for `$a ?: $b` remove spaces between `?` and `:`
                    $tokens->ensureWhitespaceAtIndex($index + 1, 0, '');
                } else {
                    // for `$a ? $b : $c` ensure space after `?`
                    $this->ensureWhitespaceExistence($tokens, $index + 1, \true);
                }
                // for `$a ? $b : $c` ensure space before `?`
                $this->ensureWhitespaceExistence($tokens, $index - 1, \false);
                continue;
            }
            if ($token->equals(':')) {
                // for `$a ? $b : $c` ensure space after `:`
                $this->ensureWhitespaceExistence($tokens, $index + 1, \true);
                $prevNonWhitespaceToken = $tokens[$tokens->getPrevNonWhitespace($index)];
                if (!$prevNonWhitespaceToken->equals('?')) {
                    // for `$a ? $b : $c` ensure space before `:`
                    $this->ensureWhitespaceExistence($tokens, $index - 1, \false);
                }
            }
        }
    }
    /**
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $index
     * @return bool
     */
    private function belongsToAlternativeSyntax($tokens, $index)
    {
        if (!$tokens[$index]->equals(':')) {
            return \false;
        }
        $closeParenthesisIndex = $tokens->getPrevMeaningfulToken($index);
        if ($tokens[$closeParenthesisIndex]->isGivenKind(\T_ELSE)) {
            return \true;
        }
        if (!$tokens[$closeParenthesisIndex]->equals(')')) {
            return \false;
        }
        $openParenthesisIndex = $tokens->findBlockStart(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $closeParenthesisIndex);
        $alternativeControlStructureIndex = $tokens->getPrevMeaningfulToken($openParenthesisIndex);
        return $tokens[$alternativeControlStructureIndex]->isGivenKind([\T_DECLARE, \T_ELSEIF, \T_FOR, \T_FOREACH, \T_IF, \T_SWITCH, \T_WHILE]);
    }
    /**
     * @return mixed[]
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $switchIndex
     */
    private function getColonIndicesForSwitch($tokens, $switchIndex)
    {
        return \array_map(static function (CaseAnalysis $caseAnalysis) {
            return $caseAnalysis->getColonIndex();
        }, (new SwitchAnalyzer())->getSwitchAnalysis($tokens, $switchIndex)->getCases());
    }
    /**
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $index
     * @param bool $after
     */
    private function ensureWhitespaceExistence($tokens, $index, $after)
    {
        if ($tokens[$index]->isWhitespace()) {
            if (\false === \strpos($tokens[$index]->getContent(), "\n") && !$tokens[$index - 1]->isComment()) {
                $tokens[$index] = new Token([\T_WHITESPACE, ' ']);
            }
            return;
        }
        $index += $after ? 0 : 1;
        $tokens->insertAt($index, new Token([\T_WHITESPACE, ' ']));
    }
}
