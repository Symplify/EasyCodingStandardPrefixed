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
namespace PhpCsFixer\Tokenizer\Transformer;

use PhpCsFixer\Tokenizer\AbstractTransformer;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * Transforms attribute related Tokens.
 *
 * @internal
 */
final class AttributeTransformer extends AbstractTransformer
{
    /**
     * {@inheritdoc}
     * @return int
     */
    public function getPriority()
    {
        // must run before all other transformers that might touch attributes
        return 200;
    }
    /**
     * {@inheritdoc}
     * @return int
     */
    public function getRequiredPhpVersionId()
    {
        return 80000;
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param \PhpCsFixer\Tokenizer\Token $token
     * @param int $index
     */
    public function process($tokens, $token, $index)
    {
        if (!$tokens[$index]->isGivenKind(\T_ATTRIBUTE)) {
            return;
        }
        $level = 1;
        do {
            ++$index;
            if ($tokens[$index]->equals('[')) {
                ++$level;
            } elseif ($tokens[$index]->equals(']')) {
                --$level;
            }
        } while (0 < $level);
        $tokens[$index] = new Token([CT::T_ATTRIBUTE_CLOSE, ']']);
    }
    /**
     * {@inheritdoc}
     * @return mixed[]
     */
    public function getCustomTokens()
    {
        return [CT::T_ATTRIBUTE_CLOSE];
    }
}
