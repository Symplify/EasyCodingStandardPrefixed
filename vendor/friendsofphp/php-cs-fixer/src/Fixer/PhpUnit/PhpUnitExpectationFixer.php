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

use PhpCsFixer\Fixer\AbstractPhpUnitFixer;
use PhpCsFixer\Fixer\ConfigurationDefinitionFixerInterface;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolver;
use PhpCsFixer\FixerConfiguration\FixerOptionBuilder;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\Analyzer\ArgumentsAnalyzer;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class PhpUnitExpectationFixer extends \PhpCsFixer\Fixer\AbstractPhpUnitFixer implements \PhpCsFixer\Fixer\ConfigurationDefinitionFixerInterface, \PhpCsFixer\Fixer\WhitespacesAwareFixerInterface
{
    /**
     * @var array<string, string>
     */
    private $methodMap = [];
    /**
     * {@inheritdoc}
     */
    public function configure(array $configuration = null)
    {
        parent::configure($configuration);
        $this->methodMap = ['setExpectedException' => 'expectExceptionMessage'];
        if (\PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::fulfills($this->configuration['target'], \PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::VERSION_5_6)) {
            $this->methodMap['setExpectedExceptionRegExp'] = 'expectExceptionMessageRegExp';
        }
        if (\PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::fulfills($this->configuration['target'], \PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::VERSION_8_4)) {
            $this->methodMap['setExpectedExceptionRegExp'] = 'expectExceptionMessageMatches';
            $this->methodMap['expectExceptionMessageRegExp'] = 'expectExceptionMessageMatches';
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('Usages of `->setExpectedException*` methods MUST be replaced by `->expectException*` methods.', [new \PhpCsFixer\FixerDefinition\CodeSample('<?php
final class MyTest extends \\PHPUnit_Framework_TestCase
{
    public function testFoo()
    {
        $this->setExpectedException("RuntimeException", "Msg", 123);
        foo();
    }

    public function testBar()
    {
        $this->setExpectedExceptionRegExp("RuntimeException", "/Msg.*/", 123);
        bar();
    }
}
'), new \PhpCsFixer\FixerDefinition\CodeSample('<?php
final class MyTest extends \\PHPUnit_Framework_TestCase
{
    public function testFoo()
    {
        $this->setExpectedException("RuntimeException", null, 123);
        foo();
    }

    public function testBar()
    {
        $this->setExpectedExceptionRegExp("RuntimeException", "/Msg.*/", 123);
        bar();
    }
}
', ['target' => \PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::VERSION_8_4]), new \PhpCsFixer\FixerDefinition\CodeSample('<?php
final class MyTest extends \\PHPUnit_Framework_TestCase
{
    public function testFoo()
    {
        $this->setExpectedException("RuntimeException", null, 123);
        foo();
    }

    public function testBar()
    {
        $this->setExpectedExceptionRegExp("RuntimeException", "/Msg.*/", 123);
        bar();
    }
}
', ['target' => \PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::VERSION_5_6]), new \PhpCsFixer\FixerDefinition\CodeSample('<?php
final class MyTest extends \\PHPUnit_Framework_TestCase
{
    public function testFoo()
    {
        $this->setExpectedException("RuntimeException", "Msg", 123);
        foo();
    }

    public function testBar()
    {
        $this->setExpectedExceptionRegExp("RuntimeException", "/Msg.*/", 123);
        bar();
    }
}
', ['target' => \PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::VERSION_5_2])], null, 'Risky when PHPUnit classes are overridden or not accessible, or when project has PHPUnit incompatibilities.');
    }
    /**
     * {@inheritdoc}
     *
     * Must run after PhpUnitNoExpectationAnnotationFixer.
     */
    public function getPriority()
    {
        return 0;
    }
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
    protected function createConfigurationDefinition()
    {
        return new \PhpCsFixer\FixerConfiguration\FixerConfigurationResolver([(new \PhpCsFixer\FixerConfiguration\FixerOptionBuilder('target', 'Target version of PHPUnit.'))->setAllowedTypes(['string'])->setAllowedValues([\PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::VERSION_5_2, \PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::VERSION_5_6, \PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::VERSION_8_4, \PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::VERSION_NEWEST])->setDefault(\PhpCsFixer\Fixer\PhpUnit\PhpUnitTargetVersion::VERSION_NEWEST)->getOption()]);
    }
    /**
     * {@inheritdoc}
     */
    protected function applyPhpUnitClassFix(\PhpCsFixer\Tokenizer\Tokens $tokens, $startIndex, $endIndex)
    {
        $argumentsAnalyzer = new \PhpCsFixer\Tokenizer\Analyzer\ArgumentsAnalyzer();
        $oldMethodSequence = [new \PhpCsFixer\Tokenizer\Token([\T_VARIABLE, '$this']), new \PhpCsFixer\Tokenizer\Token([\T_OBJECT_OPERATOR, '->']), [\T_STRING]];
        for ($index = $startIndex; $startIndex < $endIndex; ++$index) {
            $match = $tokens->findSequence($oldMethodSequence, $index);
            if (null === $match) {
                return;
            }
            list($thisIndex, , $index) = \array_keys($match);
            if (!isset($this->methodMap[$tokens[$index]->getContent()])) {
                continue;
            }
            $openIndex = $tokens->getNextTokenOfKind($index, ['(']);
            $closeIndex = $tokens->findBlockEnd(\PhpCsFixer\Tokenizer\Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $openIndex);
            $commaIndex = $tokens->getPrevMeaningfulToken($closeIndex);
            if ($tokens[$commaIndex]->equals(',')) {
                $tokens->removeTrailingWhitespace($commaIndex);
                $tokens->clearAt($commaIndex);
            }
            $arguments = $argumentsAnalyzer->getArguments($tokens, $openIndex, $closeIndex);
            $argumentsCnt = \count($arguments);
            $argumentsReplacements = ['expectException', $this->methodMap[$tokens[$index]->getContent()], 'expectExceptionCode'];
            $indent = $this->whitespacesConfig->getLineEnding() . $this->detectIndent($tokens, $thisIndex);
            $isMultilineWhitespace = \false;
            for ($cnt = $argumentsCnt - 1; $cnt >= 1; --$cnt) {
                $argStart = \array_keys($arguments)[$cnt];
                $argBefore = $tokens->getPrevMeaningfulToken($argStart);
                if ('expectExceptionMessage' === $argumentsReplacements[$cnt]) {
                    $paramIndicatorIndex = $tokens->getNextMeaningfulToken($argBefore);
                    $afterParamIndicatorIndex = $tokens->getNextMeaningfulToken($paramIndicatorIndex);
                    if ($tokens[$paramIndicatorIndex]->equals([\T_STRING, 'null'], \false) && $tokens[$afterParamIndicatorIndex]->equals(')')) {
                        if ($tokens[$argBefore + 1]->isWhitespace()) {
                            $tokens->clearTokenAndMergeSurroundingWhitespace($argBefore + 1);
                        }
                        $tokens->clearTokenAndMergeSurroundingWhitespace($argBefore);
                        $tokens->clearTokenAndMergeSurroundingWhitespace($paramIndicatorIndex);
                        continue;
                    }
                }
                $isMultilineWhitespace = $isMultilineWhitespace || $tokens[$argStart]->isWhitespace() && !$tokens[$argStart]->isWhitespace(" \t");
                $tokensOverrideArgStart = [new \PhpCsFixer\Tokenizer\Token([\T_WHITESPACE, $indent]), new \PhpCsFixer\Tokenizer\Token([\T_VARIABLE, '$this']), new \PhpCsFixer\Tokenizer\Token([\T_OBJECT_OPERATOR, '->']), new \PhpCsFixer\Tokenizer\Token([\T_STRING, $argumentsReplacements[$cnt]]), new \PhpCsFixer\Tokenizer\Token('(')];
                $tokensOverrideArgBefore = [new \PhpCsFixer\Tokenizer\Token(')'), new \PhpCsFixer\Tokenizer\Token(';')];
                if ($isMultilineWhitespace) {
                    $tokensOverrideArgStart[] = new \PhpCsFixer\Tokenizer\Token([\T_WHITESPACE, $indent . $this->whitespacesConfig->getIndent()]);
                    \array_unshift($tokensOverrideArgBefore, new \PhpCsFixer\Tokenizer\Token([\T_WHITESPACE, $indent]));
                }
                if ($tokens[$argStart]->isWhitespace()) {
                    $tokens->overrideRange($argStart, $argStart, $tokensOverrideArgStart);
                } else {
                    $tokens->insertAt($argStart, $tokensOverrideArgStart);
                }
                $tokens->overrideRange($argBefore, $argBefore, $tokensOverrideArgBefore);
            }
            $methodName = 'expectException';
            if ('expectExceptionMessageRegExp' === $tokens[$index]->getContent()) {
                $methodName = $this->methodMap[$tokens[$index]->getContent()];
            }
            $tokens[$index] = new \PhpCsFixer\Tokenizer\Token([\T_STRING, $methodName]);
        }
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
        $explodedContent = \explode("\n", $tokens[$index - 1]->getContent());
        return \end($explodedContent);
    }
}
