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
namespace PhpCsFixer\Fixer\PhpTag;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * Fixer for rules defined in PSR2 ¶2.2.
 *
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class NoClosingTagFixer extends AbstractFixer
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('The closing `?>` tag MUST be omitted from files containing only PHP.', [new CodeSample("<?php\nclass Sample\n{\n}\n?>\n")]);
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isTokenKindFound(\T_CLOSE_TAG);
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        if (\count($tokens) < 2 || !$tokens->isMonolithicPhp() || !$tokens->isTokenKindFound(\T_CLOSE_TAG)) {
            return;
        }
        $closeTags = $tokens->findGivenKind(\T_CLOSE_TAG);
        $index = \key($closeTags);
        if (isset($tokens[$index - 1]) && $tokens[$index - 1]->isWhitespace()) {
            $tokens->clearAt($index - 1);
        }
        $tokens->clearAt($index);
        $prevIndex = $tokens->getPrevMeaningfulToken($index);
        if (!$tokens[$prevIndex]->equalsAny([';', '}', [\T_OPEN_TAG]])) {
            $tokens->insertAt($prevIndex + 1, new Token(';'));
        }
    }
}
