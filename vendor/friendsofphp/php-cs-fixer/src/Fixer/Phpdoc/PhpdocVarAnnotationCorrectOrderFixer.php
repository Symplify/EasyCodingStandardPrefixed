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
namespace PhpCsFixer\Fixer\Phpdoc;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Kuba Werłos <werlos@gmail.com>
 */
final class PhpdocVarAnnotationCorrectOrderFixer extends \PhpCsFixer\AbstractFixer
{
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('`@var` and `@type` annotations must have type and name in the correct order.', [new \PhpCsFixer\FixerDefinition\CodeSample('<?php
/** @var $foo int */
$foo = 2 + 2;
')]);
    }
    public function isCandidate(\PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        return $tokens->isTokenKindFound(\T_DOC_COMMENT);
    }
    protected function applyFix(\SplFileInfo $file, \PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind(\T_DOC_COMMENT)) {
                continue;
            }
            if (\false === \stripos($token->getContent(), '@var') && \false === \stripos($token->getContent(), '@type')) {
                continue;
            }
            $newContent = \PhpCsFixer\Preg::replace('/(@(?:type|var)\\s*)(\\$\\S+)(\\s+)([^\\$](?:[^<\\s]|<[^>]*>)*)(\\s|\\*)/i', '$1$4$3$2$5', $token->getContent());
            if ($newContent === $token->getContent()) {
                continue;
            }
            $tokens[$index] = new \PhpCsFixer\Tokenizer\Token([$token->getId(), $newContent]);
        }
    }
}
