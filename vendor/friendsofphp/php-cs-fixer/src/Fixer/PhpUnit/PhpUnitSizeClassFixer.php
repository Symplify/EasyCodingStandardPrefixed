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
namespace PhpCsFixer\Fixer\PhpUnit;

use PhpCsFixer\DocBlock\Annotation;
use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\DocBlock\Line;
use PhpCsFixer\Fixer\AbstractPhpUnitFixer;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolver;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface;
use PhpCsFixer\FixerConfiguration\FixerOptionBuilder;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Analyzer\WhitespacesAnalyzer;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Jefersson Nathan <malukenho.dev@gmail.com>
 */
final class PhpUnitSizeClassFixer extends AbstractPhpUnitFixer implements WhitespacesAwareFixerInterface, ConfigurableFixerInterface
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('All PHPUnit test cases should have `@small`, `@medium` or `@large` annotation to enable run time limits.', [new CodeSample("<?php\nclass MyTest extends TestCase {}\n"), new CodeSample("<?php\nclass MyTest extends TestCase {}\n", ['group' => 'medium'])], 'The special groups [small, medium, large] provides a way to identify tests that are taking long to be executed.');
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface
     */
    protected function createConfigurationDefinition()
    {
        return new FixerConfigurationResolver([(new FixerOptionBuilder('group', 'Define a specific group to be used in case no group is already in use'))->setAllowedValues(['small', 'medium', 'large'])->setDefault('small')->getOption()]);
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $startIndex
     * @param int $endIndex
     */
    protected function applyPhpUnitClassFix($tokens, $startIndex, $endIndex)
    {
        $classIndex = $tokens->getPrevTokenOfKind($startIndex, [[\T_CLASS]]);
        if ($this->isAbstractClass($tokens, $classIndex)) {
            return;
        }
        $docBlockIndex = $this->getDocBlockIndex($tokens, $classIndex);
        if ($this->isPHPDoc($tokens, $docBlockIndex)) {
            $this->updateDocBlockIfNeeded($tokens, $docBlockIndex);
        } else {
            $this->createDocBlock($tokens, $docBlockIndex);
        }
    }
    /**
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $i
     * @return bool
     */
    private function isAbstractClass($tokens, $i)
    {
        $typeIndex = $tokens->getPrevMeaningfulToken($i);
        return $tokens[$typeIndex]->isGivenKind(\T_ABSTRACT);
    }
    /**
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $docBlockIndex
     */
    private function createDocBlock($tokens, $docBlockIndex)
    {
        $lineEnd = $this->whitespacesConfig->getLineEnding();
        $originalIndent = WhitespacesAnalyzer::detectIndent($tokens, $tokens->getNextNonWhitespace($docBlockIndex));
        $group = $this->configuration['group'];
        $toInsert = [new Token([\T_DOC_COMMENT, '/**' . $lineEnd . "{$originalIndent} * @" . $group . $lineEnd . "{$originalIndent} */"]), new Token([\T_WHITESPACE, $lineEnd . $originalIndent])];
        $index = $tokens->getNextMeaningfulToken($docBlockIndex);
        $tokens->insertAt($index, $toInsert);
    }
    /**
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $docBlockIndex
     */
    private function updateDocBlockIfNeeded($tokens, $docBlockIndex)
    {
        $doc = new DocBlock($tokens[$docBlockIndex]->getContent());
        if (!empty($this->filterDocBlock($doc))) {
            return;
        }
        $doc = $this->makeDocBlockMultiLineIfNeeded($doc, $tokens, $docBlockIndex);
        $lines = $this->addSizeAnnotation($doc, $tokens, $docBlockIndex);
        $lines = \implode('', $lines);
        $tokens[$docBlockIndex] = new Token([\T_DOC_COMMENT, $lines]);
    }
    /**
     * @return mixed[]
     * @param \PhpCsFixer\DocBlock\DocBlock $docBlock
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $docBlockIndex
     */
    private function addSizeAnnotation($docBlock, $tokens, $docBlockIndex)
    {
        $lines = $docBlock->getLines();
        $originalIndent = WhitespacesAnalyzer::detectIndent($tokens, $docBlockIndex);
        $lineEnd = $this->whitespacesConfig->getLineEnding();
        $group = $this->configuration['group'];
        \array_splice($lines, -1, 0, $originalIndent . ' *' . $lineEnd . $originalIndent . ' * @' . $group . $lineEnd);
        return $lines;
    }
    /**
     * @param \PhpCsFixer\DocBlock\DocBlock $doc
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $docBlockIndex
     * @return \PhpCsFixer\DocBlock\DocBlock
     */
    private function makeDocBlockMultiLineIfNeeded($doc, $tokens, $docBlockIndex)
    {
        $lines = $doc->getLines();
        if (1 === \count($lines) && empty($this->filterDocBlock($doc))) {
            $lines = $this->splitUpDocBlock($lines, $tokens, $docBlockIndex);
            return new DocBlock(\implode('', $lines));
        }
        return $doc;
    }
    /**
     * Take a one line doc block, and turn it into a multi line doc block.
     *
     * @param Line[] $lines
     *
     * @return mixed[]
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $docBlockIndex
     */
    private function splitUpDocBlock(array $lines, $tokens, $docBlockIndex)
    {
        $lineContent = $this->getSingleLineDocBlockEntry($lines);
        $lineEnd = $this->whitespacesConfig->getLineEnding();
        $originalIndent = WhitespacesAnalyzer::detectIndent($tokens, $tokens->getNextNonWhitespace($docBlockIndex));
        return [new Line('/**' . $lineEnd), new Line($originalIndent . ' * ' . $lineContent . $lineEnd), new Line($originalIndent . ' */')];
    }
    /**
     * @todo check whether it's doable to use \PhpCsFixer\DocBlock\DocBlock::getSingleLineDocBlockEntry instead
     *
     * @param Line[] $lines
     * @return string
     */
    private function getSingleLineDocBlockEntry(array $lines)
    {
        $line = $lines[0];
        $line = \str_replace('*/', '', $line->getContent());
        $line = \trim($line);
        $line = \str_split($line);
        $i = \count($line);
        do {
            --$i;
        } while ('*' !== $line[$i] && '*' !== $line[$i - 1] && '/' !== $line[$i - 2]);
        if (' ' === $line[$i]) {
            ++$i;
        }
        $line = \array_slice($line, $i);
        return \implode('', $line);
    }
    /**
     * @return mixed[]
     * @param \PhpCsFixer\DocBlock\DocBlock $doc
     */
    private function filterDocBlock($doc)
    {
        return \array_filter([$doc->getAnnotationsOfType('small'), $doc->getAnnotationsOfType('large'), $doc->getAnnotationsOfType('medium')]);
    }
}
