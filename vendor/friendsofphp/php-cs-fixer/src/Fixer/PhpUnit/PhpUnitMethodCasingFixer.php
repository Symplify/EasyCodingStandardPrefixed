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
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolver;
use PhpCsFixer\FixerConfiguration\FixerOptionBuilder;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\Tokenizer\TokensAnalyzer;
use PhpCsFixer\Utils;
/**
 * @author Filippo Tessarotto <zoeslam@gmail.com>
 */
final class PhpUnitMethodCasingFixer extends \PhpCsFixer\Fixer\AbstractPhpUnitFixer implements \PhpCsFixer\Fixer\ConfigurationDefinitionFixerInterface
{
    /**
     * @internal
     */
    const CAMEL_CASE = 'camel_case';
    /**
     * @internal
     */
    const SNAKE_CASE = 'snake_case';
    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('Enforce camel (or snake) case for PHPUnit test methods, following configuration.', [new \PhpCsFixer\FixerDefinition\CodeSample('<?php
class MyTest extends \\PhpUnit\\FrameWork\\TestCase
{
    public function test_my_code() {}
}
'), new \PhpCsFixer\FixerDefinition\CodeSample('<?php
class MyTest extends \\PhpUnit\\FrameWork\\TestCase
{
    public function testMyCode() {}
}
', ['case' => self::SNAKE_CASE])]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run after PhpUnitTestAnnotationFixer.
     */
    public function getPriority()
    {
        return 0;
    }
    /**
     * {@inheritdoc}
     */
    protected function createConfigurationDefinition()
    {
        return new \PhpCsFixer\FixerConfiguration\FixerConfigurationResolver([(new \PhpCsFixer\FixerConfiguration\FixerOptionBuilder('case', 'Apply camel or snake case to test methods'))->setAllowedValues([self::CAMEL_CASE, self::SNAKE_CASE])->setDefault(self::CAMEL_CASE)->getOption()]);
    }
    /**
     * {@inheritdoc}
     */
    protected function applyPhpUnitClassFix(\PhpCsFixer\Tokenizer\Tokens $tokens, $startIndex, $endIndex)
    {
        for ($index = $endIndex - 1; $index > $startIndex; --$index) {
            if (!$this->isTestMethod($tokens, $index)) {
                continue;
            }
            $functionNameIndex = $tokens->getNextMeaningfulToken($index);
            $functionName = $tokens[$functionNameIndex]->getContent();
            $newFunctionName = $this->updateMethodCasing($functionName);
            if ($newFunctionName !== $functionName) {
                $tokens[$functionNameIndex] = new \PhpCsFixer\Tokenizer\Token([\T_STRING, $newFunctionName]);
            }
            $docBlockIndex = $this->getDocBlockIndex($tokens, $index);
            if ($this->isPHPDoc($tokens, $docBlockIndex)) {
                $this->updateDocBlock($tokens, $docBlockIndex);
            }
        }
    }
    /**
     * @param string $functionName
     *
     * @return string
     */
    private function updateMethodCasing($functionName)
    {
        if (self::CAMEL_CASE === $this->configuration['case']) {
            $newFunctionName = $functionName;
            $newFunctionName = \ucwords($newFunctionName, '_');
            $newFunctionName = \str_replace('_', '', $newFunctionName);
            $newFunctionName = \lcfirst($newFunctionName);
        } else {
            $newFunctionName = \PhpCsFixer\Utils::camelCaseToUnderscore($functionName);
        }
        return $newFunctionName;
    }
    /**
     * @param int $index
     *
     * @return bool
     */
    private function isTestMethod(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        // Check if we are dealing with a (non abstract, non lambda) function
        if (!$this->isMethod($tokens, $index)) {
            return \false;
        }
        // if the function name starts with test it's a test
        $functionNameIndex = $tokens->getNextMeaningfulToken($index);
        $functionName = $tokens[$functionNameIndex]->getContent();
        if ($this->startsWith('test', $functionName)) {
            return \true;
        }
        $docBlockIndex = $this->getDocBlockIndex($tokens, $index);
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
     * @param string $needle
     * @param string $haystack
     *
     * @return bool
     */
    private function startsWith($needle, $haystack)
    {
        return \substr($haystack, 0, \strlen($needle)) === $needle;
    }
    /**
     * @param int $docBlockIndex
     */
    private function updateDocBlock(\PhpCsFixer\Tokenizer\Tokens $tokens, $docBlockIndex)
    {
        $doc = new \PhpCsFixer\DocBlock\DocBlock($tokens[$docBlockIndex]->getContent());
        $lines = $doc->getLines();
        $docBlockNeedsUpdate = \false;
        for ($inc = 0; $inc < \count($lines); ++$inc) {
            $lineContent = $lines[$inc]->getContent();
            if (\false === \strpos($lineContent, '@depends')) {
                continue;
            }
            $newLineContent = \PhpCsFixer\Preg::replaceCallback('/(@depends\\s+)(.+)(\\b)/', function (array $matches) {
                return \sprintf('%s%s%s', $matches[1], $this->updateMethodCasing($matches[2]), $matches[3]);
            }, $lineContent);
            if ($newLineContent !== $lineContent) {
                $lines[$inc] = new \PhpCsFixer\DocBlock\Line($newLineContent);
                $docBlockNeedsUpdate = \true;
            }
        }
        if ($docBlockNeedsUpdate) {
            $lines = \implode('', $lines);
            $tokens[$docBlockIndex] = new \PhpCsFixer\Tokenizer\Token([\T_DOC_COMMENT, $lines]);
        }
    }
}
