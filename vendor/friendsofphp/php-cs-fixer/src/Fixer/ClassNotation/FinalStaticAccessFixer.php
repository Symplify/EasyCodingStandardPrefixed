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
namespace PhpCsFixer\Fixer\ClassNotation;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author ntzm
 */
final class FinalStaticAccessFixer extends \PhpCsFixer\AbstractFixer
{
    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('Converts `static` access to `self` access in final classes.', [new \PhpCsFixer\FixerDefinition\CodeSample('<?php
final class Sample
{
    public function getFoo()
    {
        return static::class;
    }
}
')]);
    }
    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        // Should be run after FinalInternalClass and PhpUnitTestCaseStaticMethodCalls
        return -1;
    }
    /**
     * {@inheritdoc}
     */
    public function isCandidate(\PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        return $tokens->isAllTokenKindsFound([\T_FINAL, \T_CLASS, \T_STATIC]);
    }
    /**
     * {@inheritdoc}
     */
    protected function applyFix(\SplFileInfo $file, \PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        for ($index = $tokens->count() - 1; 0 <= $index; --$index) {
            if (!$tokens[$index]->isGivenKind(\T_FINAL)) {
                continue;
            }
            $classTokenIndex = $tokens->getNextMeaningfulToken($index);
            if (!$tokens[$classTokenIndex]->isGivenKind(\T_CLASS)) {
                continue;
            }
            $startClassIndex = $tokens->getNextTokenOfKind($classTokenIndex, ['{']);
            $endClassIndex = $tokens->findBlockEnd(\PhpCsFixer\Tokenizer\Tokens::BLOCK_TYPE_CURLY_BRACE, $startClassIndex);
            $this->replaceStaticAccessWithSelfAccessBetween($tokens, $startClassIndex, $endClassIndex);
        }
    }
    /**
     * @param int $startIndex
     * @param int $endIndex
     */
    private function replaceStaticAccessWithSelfAccessBetween(\PhpCsFixer\Tokenizer\Tokens $tokens, $startIndex, $endIndex)
    {
        for ($index = $startIndex; $index <= $endIndex; ++$index) {
            if ($tokens[$index]->isGivenKind(\T_CLASS)) {
                $index = $this->getEndOfAnonymousClass($tokens, $index);
                continue;
            }
            if (!$tokens[$index]->isGivenKind(\T_STATIC)) {
                continue;
            }
            $doubleColonIndex = $tokens->getNextMeaningfulToken($index);
            if (!$tokens[$doubleColonIndex]->isGivenKind(\T_DOUBLE_COLON)) {
                continue;
            }
            $tokens[$index] = new \PhpCsFixer\Tokenizer\Token([\T_STRING, 'self']);
        }
    }
    /**
     * @param int $index
     *
     * @return int
     */
    private function getEndOfAnonymousClass(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        $instantiationBraceStart = $tokens->getNextMeaningfulToken($index);
        if ($tokens[$instantiationBraceStart]->equals('(')) {
            $index = $tokens->findBlockEnd(\PhpCsFixer\Tokenizer\Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $instantiationBraceStart);
        }
        $bodyBraceStart = $tokens->getNextTokenOfKind($index, ['{']);
        return $tokens->findBlockEnd(\PhpCsFixer\Tokenizer\Tokens::BLOCK_TYPE_CURLY_BRACE, $bodyBraceStart);
    }
}
