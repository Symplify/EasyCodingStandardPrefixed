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
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Haralan Dobrev <hkdobrev@gmail.com>
 */
final class LogicalOperatorsFixer extends AbstractFixer
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('Use `&&` and `||` logical operators instead of `and` and `or`.', [new CodeSample('<?php

if ($a == "foo" and ($b == "bar" or $c == "baz")) {
}
')], null, 'Risky, because you must double-check if using and/or with lower precedence was intentional.');
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isAnyTokenKindsFound([\T_LOGICAL_AND, \T_LOGICAL_OR]);
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
        foreach ($tokens as $index => $token) {
            if ($token->isGivenKind(\T_LOGICAL_AND)) {
                $tokens[$index] = new Token([\T_BOOLEAN_AND, '&&']);
            } elseif ($token->isGivenKind(\T_LOGICAL_OR)) {
                $tokens[$index] = new Token([\T_BOOLEAN_OR, '||']);
            }
        }
    }
}
