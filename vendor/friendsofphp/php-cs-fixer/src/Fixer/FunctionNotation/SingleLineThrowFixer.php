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
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Kuba Werłos <werlos@gmail.com>
 */
final class SingleLineThrowFixer extends AbstractFixer
{
    const REMOVE_WHITESPACE_AFTER_TOKENS = ['['];
    const REMOVE_WHITESPACE_AROUND_TOKENS = ['(', [\T_DOUBLE_COLON]];
    const REMOVE_WHITESPACE_BEFORE_TOKENS = [')', ']', ',', ';'];
    const THROW_END_TOKENS = [';', '(', '{', '}'];
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('Throwing exception must be done in single line.', [new CodeSample("<?php\nthrow new Exception(\n    'Error.',\n    500\n);\n")]);
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isTokenKindFound(\T_THROW);
    }
    /**
     * {@inheritdoc}
     *
     * Must run before BracesFixer, ConcatSpaceFixer.
     * @return int
     */
    public function getPriority()
    {
        // must be fun before ConcatSpaceFixer
        return 36;
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        for ($index = 0, $count = $tokens->count(); $index < $count; ++$index) {
            if (!$tokens[$index]->isGivenKind(\T_THROW)) {
                continue;
            }
            /** @var int $endCandidateIndex */
            $endCandidateIndex = $tokens->getNextTokenOfKind($index, self::THROW_END_TOKENS);
            while ($tokens[$endCandidateIndex]->equals('(')) {
                $closingBraceIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $endCandidateIndex);
                $endCandidateIndex = $tokens->getNextTokenOfKind($closingBraceIndex, self::THROW_END_TOKENS);
            }
            $this->trimNewLines($tokens, $index, $tokens->getPrevMeaningfulToken($endCandidateIndex));
        }
    }
    /**
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $startIndex
     * @param int $endIndex
     */
    private function trimNewLines($tokens, $startIndex, $endIndex)
    {
        for ($index = $startIndex; $index < $endIndex; ++$index) {
            $content = $tokens[$index]->getContent();
            if ($tokens[$index]->isGivenKind(\T_COMMENT)) {
                if (0 === \strpos($content, '//')) {
                    $content = '/*' . \substr($content, 2) . ' */';
                    $tokens->clearAt($index + 1);
                } elseif (0 === \strpos($content, '#')) {
                    $content = '/*' . \substr($content, 1) . ' */';
                    $tokens->clearAt($index + 1);
                } elseif (\false !== Preg::match('/\\R/', $content)) {
                    $content = Preg::replace('/\\R/', ' ', $content);
                }
                $tokens[$index] = new Token([\T_COMMENT, $content]);
                continue;
            }
            if (!$tokens[$index]->isGivenKind(\T_WHITESPACE)) {
                continue;
            }
            if (0 === Preg::match('/\\R/', $content)) {
                continue;
            }
            $prevIndex = $tokens->getNonEmptySibling($index, -1);
            if ($this->isPreviousTokenToClear($tokens[$prevIndex])) {
                $tokens->clearAt($index);
                continue;
            }
            $nextIndex = $tokens->getNonEmptySibling($index, 1);
            if ($this->isNextTokenToClear($tokens[$nextIndex]) && !$tokens[$prevIndex]->isGivenKind(\T_FUNCTION)) {
                $tokens->clearAt($index);
                continue;
            }
            $tokens[$index] = new Token([\T_WHITESPACE, ' ']);
        }
    }
    /**
     * @return bool
     * @param \PhpCsFixer\Tokenizer\Token $token
     */
    private function isPreviousTokenToClear($token)
    {
        static $tokens = null;
        if (null === $tokens) {
            $tokens = \array_merge(self::REMOVE_WHITESPACE_AFTER_TOKENS, self::REMOVE_WHITESPACE_AROUND_TOKENS);
        }
        return $token->equalsAny($tokens) || $token->isObjectOperator();
    }
    /**
     * @return bool
     * @param \PhpCsFixer\Tokenizer\Token $token
     */
    private function isNextTokenToClear($token)
    {
        static $tokens = null;
        if (null === $tokens) {
            $tokens = \array_merge(self::REMOVE_WHITESPACE_AROUND_TOKENS, self::REMOVE_WHITESPACE_BEFORE_TOKENS);
        }
        return $token->equalsAny($tokens) || $token->isObjectOperator();
    }
}
