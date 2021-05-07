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
namespace PhpCsFixer\Fixer\ArrayNotation;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolver;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface;
use PhpCsFixer\FixerConfiguration\FixerOptionBuilder;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\FixerDefinition\VersionSpecification;
use PhpCsFixer\FixerDefinition\VersionSpecificCodeSample;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Gregor Harlan <gharlan@web.de>
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 * @author SpacePossum
 */
final class ArraySyntaxFixer extends AbstractFixer implements ConfigurableFixerInterface
{
    private $candidateTokenKind;
    private $fixCallback;
    /**
     * {@inheritdoc}
     * @param mixed[] $configuration
     * @return void
     */
    public function configure($configuration)
    {
        parent::configure($configuration);
        $this->resolveCandidateTokenKind();
        $this->resolveFixCallback();
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('PHP arrays should be declared using the configured syntax.', [new VersionSpecificCodeSample("<?php\narray(1,2);\n", new VersionSpecification(50400)), new CodeSample("<?php\n[1,2];\n", ['syntax' => 'long'])]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run before BinaryOperatorSpacesFixer, TernaryOperatorSpacesFixer.
     * @return int
     */
    public function getPriority()
    {
        return 1;
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isTokenKindFound($this->candidateTokenKind);
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        $callback = $this->fixCallback;
        for ($index = $tokens->count() - 1; 0 <= $index; --$index) {
            if ($tokens[$index]->isGivenKind($this->candidateTokenKind)) {
                $this->{$callback}($tokens, $index);
            }
        }
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface
     */
    protected function createConfigurationDefinition()
    {
        return new FixerConfigurationResolver([(new FixerOptionBuilder('syntax', 'Whether to use the `long` or `short` array syntax.'))->setAllowedValues(['long', 'short'])->setDefault('short')->getOption()]);
    }
    /**
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $index
     */
    private function fixToLongArraySyntax($tokens, $index)
    {
        $closeIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_ARRAY_SQUARE_BRACE, $index);
        $tokens[$index] = new Token('(');
        $tokens[$closeIndex] = new Token(')');
        $tokens->insertAt($index, new Token([\T_ARRAY, 'array']));
    }
    /**
     * @return void
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $index
     */
    private function fixToShortArraySyntax($tokens, $index)
    {
        $openIndex = $tokens->getNextTokenOfKind($index, ['(']);
        $closeIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $openIndex);
        $tokens[$openIndex] = new Token([CT::T_ARRAY_SQUARE_BRACE_OPEN, '[']);
        $tokens[$closeIndex] = new Token([CT::T_ARRAY_SQUARE_BRACE_CLOSE, ']']);
        $tokens->clearTokenAndMergeSurroundingWhitespace($index);
    }
    /**
     * @return void
     */
    private function resolveFixCallback()
    {
        $this->fixCallback = \sprintf('fixTo%sArraySyntax', \ucfirst($this->configuration['syntax']));
    }
    /**
     * @return void
     */
    private function resolveCandidateTokenKind()
    {
        $this->candidateTokenKind = 'long' === $this->configuration['syntax'] ? CT::T_ARRAY_SQUARE_BRACE_OPEN : \T_ARRAY;
    }
}
