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
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\VersionSpecification;
use PhpCsFixer\FixerDefinition\VersionSpecificCodeSample;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Gregor Harlan
 */
final class HeredocIndentationFixer extends \PhpCsFixer\AbstractFixer implements \PhpCsFixer\Fixer\WhitespacesAwareFixerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('Heredoc/nowdoc content must be properly indented. Requires PHP >= 7.3.', [new \PhpCsFixer\FixerDefinition\VersionSpecificCodeSample(<<<'SAMPLE'
<?php

namespace _PhpScoperbaf90856897c;

$a = <<<EOD
abc
    def
EOD
;

SAMPLE
, new \PhpCsFixer\FixerDefinition\VersionSpecification(70300)), new \PhpCsFixer\FixerDefinition\VersionSpecificCodeSample(<<<'SAMPLE'
<?php

namespace _PhpScoperbaf90856897c;

$a = <<<'EOD'
abc
    def
EOD
;

SAMPLE
, new \PhpCsFixer\FixerDefinition\VersionSpecification(70300))]);
    }
    /**
     * {@inheritdoc}
     */
    public function isCandidate(\PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        return \PHP_VERSION_ID >= 70300 && $tokens->isTokenKindFound(\T_START_HEREDOC);
    }
    protected function applyFix(\SplFileInfo $file, \PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        for ($index = \count($tokens) - 1; 0 <= $index; --$index) {
            if (!$tokens[$index]->isGivenKind(\T_END_HEREDOC)) {
                continue;
            }
            $end = $index;
            $index = $tokens->getPrevTokenOfKind($index, [[\T_START_HEREDOC]]);
            $this->fixIndentation($tokens, $index, $end);
        }
    }
    /**
     * @param int $start
     * @param int $end
     */
    private function fixIndentation(\PhpCsFixer\Tokenizer\Tokens $tokens, $start, $end)
    {
        $indent = $this->getIndentAt($tokens, $start) . $this->whitespacesConfig->getIndent();
        \PhpCsFixer\Preg::match('/^[ \\t]*/', $tokens[$end]->getContent(), $matches);
        $currentIndent = $matches[0];
        $currentIndentLength = \strlen($currentIndent);
        $content = $indent . \substr($tokens[$end]->getContent(), $currentIndentLength);
        $tokens[$end] = new \PhpCsFixer\Tokenizer\Token([\T_END_HEREDOC, $content]);
        if ($end === $start + 1) {
            return;
        }
        for ($index = $end - 1, $last = \true; $index > $start; --$index, $last = \false) {
            if (!$tokens[$index]->isGivenKind([\T_ENCAPSED_AND_WHITESPACE, \T_WHITESPACE])) {
                continue;
            }
            $content = $tokens[$index]->getContent();
            if ('' !== $currentIndent) {
                $content = \PhpCsFixer\Preg::replace('/(?<=\\v)(?!' . $currentIndent . ')[ \\t]+/', '', $content);
            }
            $regexEnd = $last && !$currentIndent ? '(?!\\v|$)' : '(?!\\v)';
            $content = \PhpCsFixer\Preg::replace('/(?<=\\v)' . $currentIndent . $regexEnd . '/', $indent, $content);
            $tokens[$index] = new \PhpCsFixer\Tokenizer\Token([$tokens[$index]->getId(), $content]);
        }
        ++$index;
        if (!$tokens[$index]->isGivenKind(\T_ENCAPSED_AND_WHITESPACE)) {
            $tokens->insertAt($index, new \PhpCsFixer\Tokenizer\Token([\T_ENCAPSED_AND_WHITESPACE, $indent]));
            return;
        }
        $content = $tokens[$index]->getContent();
        if (!\in_array($content[0], ["\r", "\n"], \true) && (!$currentIndent || $currentIndent === \substr($content, 0, $currentIndentLength))) {
            $content = $indent . \substr($content, $currentIndentLength);
        } elseif ($currentIndent) {
            $content = \PhpCsFixer\Preg::replace('/^(?!' . $currentIndent . ')[ \\t]+/', '', $content);
        }
        $tokens[$index] = new \PhpCsFixer\Tokenizer\Token([\T_ENCAPSED_AND_WHITESPACE, $content]);
    }
    /**
     * @param int $index
     *
     * @return string
     */
    private function getIndentAt(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        for (; $index >= 0; --$index) {
            if (!$tokens[$index]->isGivenKind([\T_WHITESPACE, \T_INLINE_HTML, \T_OPEN_TAG])) {
                continue;
            }
            $content = $tokens[$index]->getContent();
            if ($tokens[$index]->isWhitespace() && $tokens[$index - 1]->isGivenKind(\T_OPEN_TAG)) {
                $content = $tokens[$index - 1]->getContent() . $content;
            }
            if (1 === \PhpCsFixer\Preg::match('/\\R([ \\t]*)$/', $content, $matches)) {
                return $matches[1];
            }
        }
        return '';
    }
}
