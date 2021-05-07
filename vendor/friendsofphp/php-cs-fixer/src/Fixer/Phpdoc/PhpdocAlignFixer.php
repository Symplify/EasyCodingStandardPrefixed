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
use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerConfiguration\AllowedValueSubset;
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
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 * @author Graham Campbell <graham@alt-three.com>
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class PhpdocAlignFixer extends AbstractFixer implements ConfigurableFixerInterface, WhitespacesAwareFixerInterface
{
    /**
     * @internal
     */
    const ALIGN_LEFT = 'left';
    /**
     * @internal
     */
    const ALIGN_VERTICAL = 'vertical';
    const ALIGNABLE_TAGS = ['param', 'property', 'property-read', 'property-write', 'return', 'throws', 'type', 'var', 'method'];
    const TAGS_WITH_NAME = ['param', 'property'];
    const TAGS_WITH_METHOD_SIGNATURE = ['method'];
    /**
     * @var string
     */
    private $regex;
    /**
     * @var string
     */
    private $regexCommentLine;
    /**
     * @var string
     */
    private $align;
    /**
     * {@inheritdoc}
     * @param mixed[] $configuration
     * @return void
     */
    public function configure($configuration)
    {
        parent::configure($configuration);
        $tagsWithNameToAlign = \array_intersect($this->configuration['tags'], self::TAGS_WITH_NAME);
        $tagsWithMethodSignatureToAlign = \array_intersect($this->configuration['tags'], self::TAGS_WITH_METHOD_SIGNATURE);
        $tagsWithoutNameToAlign = \array_diff($this->configuration['tags'], $tagsWithNameToAlign, $tagsWithMethodSignatureToAlign);
        $types = [];
        $indent = '(?P<indent>(?: {2}|\\t)*)';
        // e.g. @param <hint> <$var>
        if (!empty($tagsWithNameToAlign)) {
            $types[] = '(?P<tag>' . \implode('|', $tagsWithNameToAlign) . ')\\s+(?P<hint>[^$]+?)\\s+(?P<var>(?:&|\\.{3})?\\$[^\\s]+)';
        }
        // e.g. @return <hint>
        if (!empty($tagsWithoutNameToAlign)) {
            $types[] = '(?P<tag2>' . \implode('|', $tagsWithoutNameToAlign) . ')\\s+(?P<hint2>[^\\s]+?)';
        }
        // e.g. @method <hint> <signature>
        if (!empty($tagsWithMethodSignatureToAlign)) {
            $types[] = '(?P<tag3>' . \implode('|', $tagsWithMethodSignatureToAlign) . ')(\\s+(?P<hint3>[^\\s(]+)|)\\s+(?P<signature>.+\\))';
        }
        // optional <desc>
        $desc = '(?:\\s+(?P<desc>\\V*))';
        $this->regex = '/^' . $indent . ' \\* @(?:' . \implode('|', $types) . ')' . $desc . '\\s*$/u';
        $this->regexCommentLine = '/^' . $indent . ' \\*(?! @)(?:\\s+(?P<desc>\\V+))(?<!\\*\\/)\\r?$/u';
        $this->align = $this->configuration['align'];
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        $code = <<<'EOF'
<?php

namespace ECSPrefix20210507;

/**
 * @param  EngineInterface $templating
 * @param string      $format
 * @param  int  $code       an HTTP response status code
 * @param    bool         $debug
 * @param  mixed    &$reference     a parameter passed by reference
 */

EOF;
        return new FixerDefinition('All items of the given phpdoc tags must be either left-aligned or (by default) aligned vertically.', [new CodeSample($code), new CodeSample($code, ['align' => self::ALIGN_VERTICAL]), new CodeSample($code, ['align' => self::ALIGN_LEFT])]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run after AlignMultilineCommentFixer, CommentToPhpdocFixer, CommentToPhpdocFixer, GeneralPhpdocAnnotationRemoveFixer, GeneralPhpdocTagRenameFixer, NoBlankLinesAfterPhpdocFixer, NoEmptyPhpdocFixer, NoSuperfluousPhpdocTagsFixer, PhpdocAddMissingParamAnnotationFixer, PhpdocAddMissingParamAnnotationFixer, PhpdocAnnotationWithoutDotFixer, PhpdocIndentFixer, PhpdocIndentFixer, PhpdocInlineTagNormalizerFixer, PhpdocLineSpanFixer, PhpdocNoAccessFixer, PhpdocNoAliasTagFixer, PhpdocNoEmptyReturnFixer, PhpdocNoPackageFixer, PhpdocNoUselessInheritdocFixer, PhpdocOrderByValueFixer, PhpdocOrderFixer, PhpdocReturnSelfReferenceFixer, PhpdocScalarFixer, PhpdocScalarFixer, PhpdocSeparationFixer, PhpdocSingleLineVarSpacingFixer, PhpdocSummaryFixer, PhpdocTagCasingFixer, PhpdocTagTypeFixer, PhpdocToCommentFixer, PhpdocToCommentFixer, PhpdocToParamTypeFixer, PhpdocToPropertyTypeFixer, PhpdocToReturnTypeFixer, PhpdocTrimConsecutiveBlankLineSeparationFixer, PhpdocTrimFixer, PhpdocTypesFixer, PhpdocTypesFixer, PhpdocTypesOrderFixer, PhpdocVarAnnotationCorrectOrderFixer, PhpdocVarWithoutNameFixer.
     * @return int
     */
    public function getPriority()
    {
        /*
         * Should be run after all other docblock fixers. This because they
         * modify other annotations to change their type and or separation
         * which totally change the behavior of this fixer. It's important that
         * annotations are of the correct type, and are grouped correctly
         * before running this fixer.
         */
        return -42;
    }
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
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind(\T_DOC_COMMENT)) {
                continue;
            }
            $content = $token->getContent();
            $docBlock = new DocBlock($content);
            $this->fixDocBlock($docBlock);
            $newContent = $docBlock->getContent();
            if ($newContent !== $content) {
                $tokens[$index] = new Token([\T_DOC_COMMENT, $newContent]);
            }
        }
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface
     */
    protected function createConfigurationDefinition()
    {
        $tags = new FixerOptionBuilder('tags', 'The tags that should be aligned.');
        $tags->setAllowedTypes(['array'])->setAllowedValues([new AllowedValueSubset(self::ALIGNABLE_TAGS)])->setDefault(['method', 'param', 'property', 'return', 'throws', 'type', 'var']);
        $align = new FixerOptionBuilder('align', 'Align comments');
        $align->setAllowedTypes(['string'])->setAllowedValues([self::ALIGN_LEFT, self::ALIGN_VERTICAL])->setDefault(self::ALIGN_VERTICAL);
        return new FixerConfigurationResolver([$tags->getOption(), $align->getOption()]);
    }
    /**
     * @return void
     * @param \PhpCsFixer\DocBlock\DocBlock $docBlock
     */
    private function fixDocBlock($docBlock)
    {
        $lineEnding = $this->whitespacesConfig->getLineEnding();
        for ($i = 0, $l = \count($docBlock->getLines()); $i < $l; ++$i) {
            $items = [];
            $matches = $this->getMatches($docBlock->getLine($i)->getContent());
            if (null === $matches) {
                continue;
            }
            $current = $i;
            $items[] = $matches;
            while (\true) {
                if (null === $docBlock->getLine(++$i)) {
                    break 2;
                }
                $matches = $this->getMatches($docBlock->getLine($i)->getContent(), \true);
                if (null === $matches) {
                    break;
                }
                $items[] = $matches;
            }
            // compute the max length of the tag, hint and variables
            $tagMax = 0;
            $hintMax = 0;
            $varMax = 0;
            foreach ($items as $item) {
                if (null === $item['tag']) {
                    continue;
                }
                $tagMax = \max($tagMax, \strlen($item['tag']));
                $hintMax = \max($hintMax, \strlen($item['hint']));
                $varMax = \max($varMax, \strlen($item['var']));
            }
            $currTag = null;
            // update
            foreach ($items as $j => $item) {
                if (null === $item['tag']) {
                    if ('@' === $item['desc'][0]) {
                        $docBlock->getLine($current + $j)->setContent($item['indent'] . ' * ' . $item['desc'] . $lineEnding);
                        continue;
                    }
                    $extraIndent = 2;
                    if (\in_array($currTag, self::TAGS_WITH_NAME, \true) || \in_array($currTag, self::TAGS_WITH_METHOD_SIGNATURE, \true)) {
                        $extraIndent = 3;
                    }
                    $line = $item['indent'] . ' *  ' . $this->getIndent($tagMax + $hintMax + $varMax + $extraIndent, $this->getLeftAlignedDescriptionIndent($items, $j)) . $item['desc'] . $lineEnding;
                    $docBlock->getLine($current + $j)->setContent($line);
                    continue;
                }
                $currTag = $item['tag'];
                $line = $item['indent'] . ' * @' . $item['tag'] . $this->getIndent($tagMax - \strlen($item['tag']) + 1, $item['hint'] ? 1 : 0) . $item['hint'];
                if (!empty($item['var'])) {
                    $line .= $this->getIndent(($hintMax ?: -1) - \strlen($item['hint']) + 1) . $item['var'] . (!empty($item['desc']) ? $this->getIndent($varMax - \strlen($item['var']) + 1) . $item['desc'] . $lineEnding : $lineEnding);
                } elseif (!empty($item['desc'])) {
                    $line .= $this->getIndent($hintMax - \strlen($item['hint']) + 1) . $item['desc'] . $lineEnding;
                } else {
                    $line .= $lineEnding;
                }
                $docBlock->getLine($current + $j)->setContent($line);
            }
        }
    }
    /**
     * @return mixed[]|null
     * @param string $line
     * @param bool $matchCommentOnly
     */
    private function getMatches($line, $matchCommentOnly = \false)
    {
        if (Preg::match($this->regex, $line, $matches)) {
            if (!empty($matches['tag2'])) {
                $matches['tag'] = $matches['tag2'];
                $matches['hint'] = $matches['hint2'];
                $matches['var'] = '';
            }
            if (!empty($matches['tag3'])) {
                $matches['tag'] = $matches['tag3'];
                $matches['hint'] = $matches['hint3'];
                $matches['var'] = $matches['signature'];
            }
            if (isset($matches['hint'])) {
                $matches['hint'] = \trim($matches['hint']);
            }
            return $matches;
        }
        if ($matchCommentOnly && Preg::match($this->regexCommentLine, $line, $matches)) {
            $matches['tag'] = null;
            $matches['var'] = '';
            $matches['hint'] = '';
            return $matches;
        }
        return null;
    }
    /**
     * @param int $verticalAlignIndent
     * @param int $leftAlignIndent
     * @return string
     */
    private function getIndent($verticalAlignIndent, $leftAlignIndent = 1)
    {
        $indent = self::ALIGN_VERTICAL === $this->align ? $verticalAlignIndent : $leftAlignIndent;
        return \str_repeat(' ', $indent);
    }
    /**
     * @param array[] $items
     * @param int $index
     * @return int
     */
    private function getLeftAlignedDescriptionIndent(array $items, $index)
    {
        if (self::ALIGN_LEFT !== $this->align) {
            return 0;
        }
        // Find last tagged line:
        $item = null;
        for (; $index >= 0; --$index) {
            $item = $items[$index];
            if (null !== $item['tag']) {
                break;
            }
        }
        // No last tag found — no indent:
        if (null === $item) {
            return 0;
        }
        // Indent according to existing values:
        return $this->getSentenceIndent($item['tag']) + $this->getSentenceIndent($item['hint']) + $this->getSentenceIndent($item['var']);
    }
    /**
     * Get indent for sentence.
     * @param string|null $sentence
     * @return int
     */
    private function getSentenceIndent($sentence)
    {
        if (null === $sentence) {
            return 0;
        }
        $length = \strlen($sentence);
        return 0 === $length ? 0 : $length + 1;
    }
}
