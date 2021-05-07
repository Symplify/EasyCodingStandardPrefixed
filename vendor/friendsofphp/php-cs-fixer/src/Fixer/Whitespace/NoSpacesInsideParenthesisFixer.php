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
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * Fixer for rules defined in PSR2 ¶4.3, ¶4.6, ¶5.
 *
 * @author Marc Aubé
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class NoSpacesInsideParenthesisFixer extends AbstractFixer
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('There MUST NOT be a space after the opening parenthesis. There MUST NOT be a space before the closing parenthesis.', [new CodeSample("<?php\nif ( \$a ) {\n    foo( );\n}\n"), new CodeSample("<?php\nfunction foo( \$bar, \$baz )\n{\n}\n")]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run before FunctionToConstantFixer.
     * Must run after CombineConsecutiveIssetsFixer, CombineNestedDirnameFixer, LambdaNotUsedImportFixer, NoUselessSprintfFixer, PowToExponentiationFixer.
     * @return int
     */
    public function getPriority()
    {
        return 2;
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isTokenKindFound('(');
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
            if (!$token->equals('(')) {
                continue;
            }
            $prevIndex = $tokens->getPrevMeaningfulToken($index);
            // ignore parenthesis for T_ARRAY
            if (null !== $prevIndex && $tokens[$prevIndex]->isGivenKind(\T_ARRAY)) {
                continue;
            }
            $endIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $index);
            // remove space after opening `(`
            if (!$tokens[$tokens->getNextNonWhitespace($index)]->isComment()) {
                $this->removeSpaceAroundToken($tokens, $index + 1);
            }
            // remove space before closing `)` if it is not `list($a, $b, )` case
            if (!$tokens[$tokens->getPrevMeaningfulToken($endIndex)]->equals(',')) {
                $this->removeSpaceAroundToken($tokens, $endIndex - 1);
            }
        }
    }
    /**
     * Remove spaces from token at a given index.
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $index
     */
    private function removeSpaceAroundToken($tokens, $index)
    {
        $token = $tokens[$index];
        if ($token->isWhitespace() && \false === \strpos($token->getContent(), "\n")) {
            $tokens->clearAt($index);
        }
    }
}
