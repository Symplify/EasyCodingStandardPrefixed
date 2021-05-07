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
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * Fixer for part of rule defined in PSR5 ¶7.22.
 *
 * @author SpacePossum
 */
final class PhpdocSingleLineVarSpacingFixer extends AbstractFixer
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('Single line `@var` PHPDoc should have proper spacing.', [new CodeSample("<?php /**@var   MyClass   \$a   */\n\$a = test();\n")]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run before PhpdocAlignFixer.
     * Must run after AlignMultilineCommentFixer, CommentToPhpdocFixer, PhpdocIndentFixer, PhpdocNoAliasTagFixer, PhpdocScalarFixer, PhpdocToCommentFixer, PhpdocTypesFixer.
     * @return int
     */
    public function getPriority()
    {
        return -10;
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isAnyTokenKindsFound([\T_COMMENT, \T_DOC_COMMENT]);
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        /** @var Token $token */
        foreach ($tokens as $index => $token) {
            if (!$token->isComment()) {
                continue;
            }
            $content = $token->getContent();
            $fixedContent = $this->fixTokenContent($content);
            if ($content !== $fixedContent) {
                $tokens[$index] = new Token([\T_DOC_COMMENT, $fixedContent]);
            }
        }
    }
    /**
     * @param string $content
     * @return string
     */
    private function fixTokenContent($content)
    {
        return Preg::replaceCallback('#^/\\*\\*\\h*@var\\h+(\\S+)\\h*(\\$\\S+)?\\h*([^\\n]*)\\*/$#', static function (array $matches) {
            $content = '/** @var';
            for ($i = 1, $m = \count($matches); $i < $m; ++$i) {
                if ('' !== $matches[$i]) {
                    $content .= ' ' . $matches[$i];
                }
            }
            return \rtrim($content) . ' */';
        }, $content);
    }
}
