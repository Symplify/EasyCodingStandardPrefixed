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
namespace PhpCsFixer\Fixer\Semicolon;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Graham Campbell <graham@alt-three.com>
 */
final class NoSinglelineWhitespaceBeforeSemicolonsFixer extends AbstractFixer
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('Single-line whitespace before closing semicolon are prohibited.', [new CodeSample("<?php \$this->foo() ;\n")]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run after CombineConsecutiveIssetsFixer, FunctionToConstantFixer, NoEmptyStatementFixer, SimplifiedIfReturnFixer, SingleImportPerStatementFixer.
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
        return $tokens->isTokenKindFound(';');
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        foreach ($tokens as $index => $token) {
            if (!$token->equals(';') || !$tokens[$index - 1]->isWhitespace(" \t")) {
                continue;
            }
            if ($tokens[$index - 2]->equals(';')) {
                // do not remove all whitespace before the semicolon because it is also whitespace after another semicolon
                if (!$tokens[$index - 1]->equals(' ')) {
                    $tokens[$index - 1] = new Token([\T_WHITESPACE, ' ']);
                }
            } elseif (!$tokens[$index - 2]->isComment()) {
                $tokens->clearAt($index - 1);
            }
        }
    }
}
