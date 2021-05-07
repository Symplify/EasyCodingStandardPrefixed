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
 * Transform named argument tokens.
 *
 * @author SpacePossum
 *
 * @internal
 */
final class NamedArgumentTransformer extends AbstractTransformer
{
    /**
     * {@inheritdoc}
     * @return int
     */
    public function getPriority()
    {
        // needs to run after TypeColonTransformer
        return -15;
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
        if (!$tokens[$index]->equals(':')) {
            return;
        }
        $stringIndex = $tokens->getPrevMeaningfulToken($index);
        if (!$tokens[$stringIndex]->isGivenKind(\T_STRING)) {
            return;
        }
        $preStringIndex = $tokens->getPrevMeaningfulToken($stringIndex);
        // if equals any [';', '{', '}', [T_OPEN_TAG]] than it is a goto label
        // if equals ')' than likely it is a type colon, but sure not a name argument
        // if equals '?' than it is part of ternary statement
        if (!$tokens[$preStringIndex]->equalsAny([',', '('])) {
            return;
        }
        $tokens[$stringIndex] = new Token([CT::T_NAMED_ARGUMENT_NAME, $tokens[$stringIndex]->getContent()]);
        $tokens[$index] = new Token([CT::T_NAMED_ARGUMENT_COLON, ':']);
    }
    /**
     * {@inheritdoc}
     * @return mixed[]
     */
    public function getCustomTokens()
    {
        return [CT::T_NAMED_ARGUMENT_COLON, CT::T_NAMED_ARGUMENT_NAME];
    }
}
