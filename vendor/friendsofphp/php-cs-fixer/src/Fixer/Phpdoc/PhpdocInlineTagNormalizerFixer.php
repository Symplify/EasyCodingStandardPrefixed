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
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolver;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface;
use PhpCsFixer\FixerConfiguration\FixerOptionBuilder;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author SpacePossum
 */
final class PhpdocInlineTagNormalizerFixer extends AbstractFixer implements ConfigurableFixerInterface
{
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isTokenKindFound(\T_DOC_COMMENT);
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('Fixes PHPDoc inline tags.', [new CodeSample("<?php\n/**\n * @{TUTORIAL}\n * {{ @link }}\n * @inheritDoc\n */\n"), new CodeSample("<?php\n/**\n * @{TUTORIAL}\n * {{ @link }}\n * @inheritDoc\n */\n", ['tags' => ['TUTORIAL']])]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run before PhpdocAlignFixer.
     * Must run after AlignMultilineCommentFixer, CommentToPhpdocFixer, PhpdocIndentFixer, PhpdocScalarFixer, PhpdocToCommentFixer, PhpdocTypesFixer.
     * @return int
     */
    public function getPriority()
    {
        return 0;
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        if (!$this->configuration['tags']) {
            return;
        }
        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind(\T_DOC_COMMENT)) {
                continue;
            }
            // Move `@` inside tag, for example @{tag} -> {@tag}, replace multiple curly brackets,
            // remove spaces between '{' and '@', remove white space between end
            // of text and closing bracket and between the tag and inline comment.
            $content = Preg::replaceCallback(\sprintf('#(?:@{+|{+\\h*@)\\h*(%s)s?([^}]*)(?:}+)#i', \implode('|', \array_map(function ($tag) {
                return \preg_quote($tag, '/');
            }, $this->configuration['tags']))), function (array $matches) {
                $doc = \trim($matches[2]);
                if ('' === $doc) {
                    return '{@' . $matches[1] . '}';
                }
                return '{@' . $matches[1] . ' ' . $doc . '}';
            }, $token->getContent());
            $tokens[$index] = new Token([\T_DOC_COMMENT, $content]);
        }
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface
     */
    protected function createConfigurationDefinition()
    {
        return new FixerConfigurationResolver([(new FixerOptionBuilder('tags', 'The list of tags to normalize'))->setAllowedTypes(['array'])->setDefault(['example', 'id', 'internal', 'inheritdoc', 'inheritdocs', 'link', 'source', 'toc', 'tutorial'])->getOption()]);
    }
}
