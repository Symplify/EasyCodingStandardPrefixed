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
namespace PhpCsFixer\Fixer\Whitespace;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * Fixer for rules defined in PSR2 ¶2.2.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author SpacePossum
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class LineEndingFixer extends AbstractFixer implements WhitespacesAwareFixerInterface
{
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('All PHP files must use same line ending.', [new CodeSample("<?php \$b = \" \$a \r\n 123\"; \$a = <<<TEST\r\nAAAAA \r\n |\r\nTEST;\n")]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run before BracesFixer.
     * @return int
     */
    public function getPriority()
    {
        return 40;
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        $ending = $this->whitespacesConfig->getLineEnding();
        for ($index = 0, $count = \count($tokens); $index < $count; ++$index) {
            $token = $tokens[$index];
            if ($token->isGivenKind(\T_ENCAPSED_AND_WHITESPACE)) {
                if ($tokens[$tokens->getNextMeaningfulToken($index)]->isGivenKind(\T_END_HEREDOC)) {
                    $tokens[$index] = new Token([$token->getId(), Preg::replace('#\\R#', $ending, $token->getContent())]);
                }
                continue;
            }
            if ($token->isGivenKind([\T_CLOSE_TAG, \T_COMMENT, \T_DOC_COMMENT, \T_OPEN_TAG, \T_START_HEREDOC, \T_WHITESPACE])) {
                $tokens[$index] = new Token([$token->getId(), Preg::replace('#\\R#', $ending, $token->getContent())]);
            }
        }
    }
}
