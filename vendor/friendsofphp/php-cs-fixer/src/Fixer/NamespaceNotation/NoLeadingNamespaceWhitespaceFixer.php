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
namespace PhpCsFixer\Fixer\NamespaceNotation;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Bram Gotink <bram@gotink.me>
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class NoLeadingNamespaceWhitespaceFixer extends AbstractFixer implements WhitespacesAwareFixerInterface
{
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isTokenKindFound(\T_NAMESPACE);
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('The namespace declaration line shouldn\'t contain leading whitespace.', [new CodeSample('<?php
 namespace Test8a;
    namespace Test8b;
')]);
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        for ($index = \count($tokens) - 1; 0 <= $index; --$index) {
            $token = $tokens[$index];
            if (!$token->isGivenKind(\T_NAMESPACE)) {
                continue;
            }
            $beforeNamespaceIndex = $index - 1;
            $beforeNamespace = $tokens[$beforeNamespaceIndex];
            if (!$beforeNamespace->isWhitespace()) {
                if (!self::endsWithWhitespace($beforeNamespace->getContent())) {
                    $tokens->insertAt($index, new Token([\T_WHITESPACE, $this->whitespacesConfig->getLineEnding()]));
                }
                continue;
            }
            $lastNewline = \strrpos($beforeNamespace->getContent(), "\n");
            if (\false === $lastNewline) {
                $beforeBeforeNamespace = $tokens[$index - 2];
                if (self::endsWithWhitespace($beforeBeforeNamespace->getContent())) {
                    $tokens->clearAt($beforeNamespaceIndex);
                } else {
                    $tokens[$beforeNamespaceIndex] = new Token([\T_WHITESPACE, ' ']);
                }
            } else {
                $tokens[$beforeNamespaceIndex] = new Token([\T_WHITESPACE, \substr($beforeNamespace->getContent(), 0, $lastNewline + 1)]);
            }
        }
    }
    /**
     * @param string $str
     * @return bool
     */
    private static function endsWithWhitespace($str)
    {
        if ('' === $str) {
            return \false;
        }
        return '' === \trim(\substr($str, -1));
    }
}
