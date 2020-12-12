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

use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\DocBlock\Line;
use PhpCsFixer\Fixer\AbstractPhpUnitFixer;
use PhpCsFixer\Fixer\ConfigurationDefinitionFixerInterface;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolver;
use PhpCsFixer\FixerConfiguration\FixerOptionBuilder;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\Tokenizer\TokensAnalyzer;
/**
 * @author Gert de Pagter
 */
final class PhpUnitTestAnnotationFixer extends \PhpCsFixer\Fixer\AbstractPhpUnitFixer implements \PhpCsFixer\Fixer\ConfigurationDefinitionFixerInterface, \PhpCsFixer\Fixer\WhitespacesAwareFixerInterface
{
    /**
     * {@inheritdoc}
     */
    public function isRisky()
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('Adds or removes @test annotations from tests, following configuration.', [new \PhpCsFixer\FixerDefinition\CodeSample('<?php
class Test extends \\PhpUnit\\FrameWork\\TestCase
{
    /**
     * @test
     */
    public function itDoesSomething() {} }' . $this->whitespacesConfig->getLineEnding()), new \PhpCsFixer\FixerDefinition\CodeSample('<?php
class Test extends \\PhpUnit\\FrameWork\\TestCase
{
public function testItDoesSomething() {}}' . $this->whitespacesConfig->getLineEnding(), ['style' => 'annotation'])], null, 'This fixer may change the name of your tests, and could cause incompatibility with' . ' abstract classes or interfaces.');
    }
    /**
     * {@inheritdoc}
     *
     * Must run before NoEmptyPhpdocFixer, PhpUnitMethodCasingFixer, PhpdocTrimFixer.
     */
    public function getPriority()
    {
        return 10;
    }
    /**
     * {@inheritdoc}
     */
    protected function applyPhpUnitClassFix(\PhpCsFixer\Tokenizer\Tokens $tokens, $startIndex, $endIndex)
    {
        if ('annotation' === $this->configuration['style']) {
            $this->applyTestAnnotation($tokens, $startIndex, $endIndex);
        } else {
            $this->applyTestPrefix($tokens, $startIndex, $endIndex);
        }
    }
    /**
     * {@inheritdoc}
     */
    protected function createConfigurationDefinition()
    {
        return new \PhpCsFixer\FixerConfiguration\FixerConfigurationResolver([(new \PhpCsFixer\FixerConfiguration\FixerOptionBuilder('style', 'Whether to use the @test annotation or not.'))->setAllowedValues(['prefix', 'annotation'])->setDefault('prefix')->getOption(), (new \PhpCsFixer\FixerConfiguration\FixerOptionBuilder('case', 'Whether to camel or snake case when adding the test prefix'))->setAllowedValues(['camel', 'snake'])->setDefault('camel')->setDeprecationMessage('Use `php_unit_method_casing` fixer instead.')->getOption()]);
    }
    /**
     * @param int $startIndex
     * @param int $endIndex
     */
    private function applyTestAnnotation(\PhpCsFixer\Tokenizer\Tokens $tokens, $startIndex, $endIndex)
    {
        for ($i = $endIndex - 1; $i > $startIndex; --$i) {
            if (!$this->isTestMethod($tokens, $i)) {
                continue;
            }
            $functionNameIndex = $tokens->getNextMeaningfulToken($i);
            $functionName = $tokens[$functionNameIndex]->getContent();
            if ($this->hasTestPrefix($functionName) && !$this->hasProperTestAnnotation($tokens, $i)) {
                $newFunctionName = $this->removeTestPrefix($functionName);
                $tokens[$functionNameIndex] = new \PhpCsFixer\Tokenizer\Token([\T_STRING, $newFunctionName]);
            }
            $docBlockIndex = $this->getDocBlockIndex($tokens, $i);
            if ($this->isPHPDoc($tokens, $docBlockIndex)) {
                $lines = $this->updateDocBlock($tokens, $docBlockIndex);
                $lines = $this->addTestAnnotation($lines, $tokens, $docBlockIndex);
                $lines = \implode('', $lines);
                $tokens[$docBlockIndex] = new \PhpCsFixer\Tokenizer\Token([\T_DOC_COMMENT, $lines]);
            } else {
                // Create a new docblock if it didn't have one before;
                $this->createDocBlock($tokens, $docBlockIndex);
            }
        }
    }
    /**
     * @param int $startIndex
     * @param int $endIndex
     */
    private function applyTestPrefix(\PhpCsFixer\Tokenizer\Tokens $tokens, $startIndex, $endIndex)
    {
        for ($i = $endIndex - 1; $i > $startIndex; --$i) {
            // We explicitly check again if the function has a doc block to save some time.
            if (!$this->isTestMethod($tokens, $i)) {
                continue;
            }
            $docBlockIndex = $this->getDocBlockIndex($tokens, $i);
            if (!$this->isPHPDoc($tokens, $docBlockIndex)) {
                continue;
            }
            $lines = $this->updateDocBlock($tokens, $docBlockIndex);
            $lines = \implode('', $lines);
            $tokens[$docBlockIndex] = new \PhpCsFixer\Tokenizer\Token([\T_DOC_COMMENT, $lines]);
            $functionNameIndex = $tokens->getNextMeaningfulToken($i);
            $functionName = $tokens[$functionNameIndex]->getContent();
            if ($this->hasTestPrefix($functionName)) {
                continue;
            }
            $newFunctionName = $this->addTestPrefix($functionName);
            $tokens[$functionNameIndex] = new \PhpCsFixer\Tokenizer\Token([\T_STRING, $newFunctionName]);
        }
    }
    /**
     * @param int$index
     *
     * @return bool
     */
    private function isTestMethod(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        // Check if we are dealing with a (non abstract, non lambda) function
        if (!$this->isMethod($tokens, $index)) {
            return \false;
        }
        // if the function name starts with test its a test
        $functionNameIndex = $tokens->getNextMeaningfulToken($index);
        $functionName = $tokens[$functionNameIndex]->getContent();
        if ($this->hasTestPrefix($functionName)) {
            return \true;
        }
        $docBlockIndex = $this->getDocBlockIndex($tokens, $index);
        // If the function doesn't have test in its name, and no doc block, its not a test
        return $this->isPHPDoc($tokens, $docBlockIndex) && \false !== \strpos($tokens[$docBlockIndex]->getContent(), '@test');
    }
    /**
     * @param int $index
     *
     * @return bool
     */
    private function isMethod(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        $tokensAnalyzer = new \PhpCsFixer\Tokenizer\TokensAnalyzer($tokens);
        return $tokens[$index]->isGivenKind(\T_FUNCTION) && !$tokensAnalyzer->isLambda($index);
    }
    /**
     * @param string $functionName
     *
     * @return bool
     */
    private function hasTestPrefix($functionName)
    {
        return 0 === \strpos($functionName, 'test');
    }
    /**
     * @param int $index
     *
     * @return bool
     */
    private function hasProperTestAnnotation(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        $docBlockIndex = $this->getDocBlockIndex($tokens, $index);
        $doc = $tokens[$docBlockIndex]->getContent();
        return 1 === \PhpCsFixer\Preg::match('/\\*\\s+@test\\b/', $doc);
    }
    /**
     * @param string $functionName
     *
     * @return string
     */
    private function removeTestPrefix($functionName)
    {
        $remainder = \PhpCsFixer\Preg::replace('/^test(?=[A-Z_])_?/', '', $functionName);
        if ('' === $remainder) {
            return $functionName;
        }
        return \lcfirst($remainder);
    }
    /**
     * @param string $functionName
     *
     * @return string
     */
    private function addTestPrefix($functionName)
    {
        if ('camel' !== $this->configuration['case']) {
            return 'test_' . $functionName;
        }
        return 'test' . \ucfirst($functionName);
    }
    /**
     * @param int $index
     *
     * @return string
     */
    private function detectIndent(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        if (!$tokens[$index - 1]->isWhitespace()) {
            return '';
            // cannot detect indent
        }
        $explodedContent = \explode($this->whitespacesConfig->getLineEnding(), $tokens[$index - 1]->getContent());
        return \end($explodedContent);
    }
    /**
     * @param int $docBlockIndex
     */
    private function createDocBlock(\PhpCsFixer\Tokenizer\Tokens $tokens, $docBlockIndex)
    {
        $lineEnd = $this->whitespacesConfig->getLineEnding();
        $originalIndent = $this->detectIndent($tokens, $tokens->getNextNonWhitespace($docBlockIndex));
        $toInsert = [new \PhpCsFixer\Tokenizer\Token([\T_DOC_COMMENT, '/**' . $lineEnd . "{$originalIndent} * @test" . $lineEnd . "{$originalIndent} */"]), new \PhpCsFixer\Tokenizer\Token([\T_WHITESPACE, $lineEnd . $originalIndent])];
        $index = $tokens->getNextMeaningfulToken($docBlockIndex);
        $tokens->insertAt($index, $toInsert);
    }
    /**
     * @param int $docBlockIndex
     *
     * @return Line[]
     */
    private function updateDocBlock(\PhpCsFixer\Tokenizer\Tokens $tokens, $docBlockIndex)
    {
        $doc = new \PhpCsFixer\DocBlock\DocBlock($tokens[$docBlockIndex]->getContent());
        $lines = $doc->getLines();
        return $this->updateLines($lines, $tokens, $docBlockIndex);
    }
    /**
     * @param Line[] $lines
     * @param int    $docBlockIndex
     *
     * @return Line[]
     */
    private function updateLines($lines, \PhpCsFixer\Tokenizer\Tokens $tokens, $docBlockIndex)
    {
        $needsAnnotation = 'annotation' === $this->configuration['style'];
        $doc = new \PhpCsFixer\DocBlock\DocBlock($tokens[$docBlockIndex]->getContent());
        for ($i = 0; $i < \count($lines); ++$i) {
            // If we need to add test annotation and it is a single line comment we need to deal with that separately
            if ($needsAnnotation && ($lines[$i]->isTheStart() && $lines[$i]->isTheEnd())) {
                if (!$this->doesDocBlockContainTest($doc)) {
                    $lines = $this->splitUpDocBlock($lines, $tokens, $docBlockIndex);
                    return $this->updateLines($lines, $tokens, $docBlockIndex);
                }
                // One we split it up, we run the function again, so we deal with other things in a proper way
            }
            if (!$needsAnnotation && \false !== \strpos($lines[$i]->getContent(), ' @test') && \false === \strpos($lines[$i]->getContent(), '@testWith') && \false === \strpos($lines[$i]->getContent(), '@testdox')) {
                // We remove @test from the doc block
                $lines[$i] = new \PhpCsFixer\DocBlock\Line(\str_replace(' @test', '', $lines[$i]->getContent()));
            }
            // ignore the line if it isn't @depends
            if (\false === \strpos($lines[$i]->getContent(), '@depends')) {
                continue;
            }
            $lines[$i] = $this->updateDependsAnnotation($lines[$i]);
        }
        return $lines;
    }
    /**
     * Take a one line doc block, and turn it into a multi line doc block.
     *
     * @param Line[] $lines
     * @param int    $docBlockIndex
     *
     * @return Line[]
     */
    private function splitUpDocBlock($lines, \PhpCsFixer\Tokenizer\Tokens $tokens, $docBlockIndex)
    {
        $lineContent = $this->getSingleLineDocBlockEntry($lines);
        $lineEnd = $this->whitespacesConfig->getLineEnding();
        $originalIndent = $this->detectIndent($tokens, $tokens->getNextNonWhitespace($docBlockIndex));
        return [new \PhpCsFixer\DocBlock\Line('/**' . $lineEnd), new \PhpCsFixer\DocBlock\Line($originalIndent . ' * ' . $lineContent . $lineEnd), new \PhpCsFixer\DocBlock\Line($originalIndent . ' */')];
    }
    /**
     * @param Line []$line
     *
     * @return string
     */
    private function getSingleLineDocBlockEntry($line)
    {
        $line = $line[0];
        $line = \str_replace('*/', '', $line);
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
     * Updates the depends tag on the current doc block.
     *
     * @return Line
     */
    private function updateDependsAnnotation(\PhpCsFixer\DocBlock\Line $line)
    {
        if ('annotation' === $this->configuration['style']) {
            return $this->removeTestPrefixFromDependsAnnotation($line);
        }
        return $this->addTestPrefixToDependsAnnotation($line);
    }
    /**
     * @return Line
     */
    private function removeTestPrefixFromDependsAnnotation(\PhpCsFixer\DocBlock\Line $line)
    {
        $line = \str_split($line->getContent());
        $dependsIndex = $this->findWhereDependsFunctionNameStarts($line);
        $dependsFunctionName = \implode('', \array_slice($line, $dependsIndex));
        if ($this->hasTestPrefix($dependsFunctionName)) {
            $dependsFunctionName = $this->removeTestPrefix($dependsFunctionName);
        }
        \array_splice($line, $dependsIndex);
        return new \PhpCsFixer\DocBlock\Line(\implode('', $line) . $dependsFunctionName);
    }
    /**
     * @return Line
     */
    private function addTestPrefixToDependsAnnotation(\PhpCsFixer\DocBlock\Line $line)
    {
        $line = \str_split($line->getContent());
        $dependsIndex = $this->findWhereDependsFunctionNameStarts($line);
        $dependsFunctionName = \implode('', \array_slice($line, $dependsIndex));
        if (!$this->hasTestPrefix($dependsFunctionName)) {
            $dependsFunctionName = $this->addTestPrefix($dependsFunctionName);
        }
        \array_splice($line, $dependsIndex);
        return new \PhpCsFixer\DocBlock\Line(\implode('', $line) . $dependsFunctionName);
    }
    /**
     * Helps to find where the function name in the doc block starts.
     *
     * @return int
     */
    private function findWhereDependsFunctionNameStarts(array $line)
    {
        $counter = \count($line);
        do {
            --$counter;
        } while (' ' !== $line[$counter]);
        return $counter + 1;
    }
    /**
     * @param Line[] $lines
     * @param int    $docBlockIndex
     *
     * @return Line[]
     */
    private function addTestAnnotation($lines, \PhpCsFixer\Tokenizer\Tokens $tokens, $docBlockIndex)
    {
        $doc = new \PhpCsFixer\DocBlock\DocBlock($tokens[$docBlockIndex]->getContent());
        if (!$this->doesDocBlockContainTest($doc)) {
            $originalIndent = $this->detectIndent($tokens, $docBlockIndex);
            $lineEnd = $this->whitespacesConfig->getLineEnding();
            \array_splice($lines, -1, 0, $originalIndent . ' *' . $lineEnd . $originalIndent . ' * @test' . $lineEnd);
        }
        return $lines;
    }
    /**
     * @return bool
     */
    private function doesDocBlockContainTest(\PhpCsFixer\DocBlock\DocBlock $doc)
    {
        return !empty($doc->getAnnotationsOfType('test'));
    }
}
