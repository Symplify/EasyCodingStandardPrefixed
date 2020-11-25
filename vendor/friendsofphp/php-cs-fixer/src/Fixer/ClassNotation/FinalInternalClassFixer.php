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
namespace PhpCsFixer\Fixer\ClassNotation;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\ConfigurationException\InvalidFixerConfigurationException;
use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\Fixer\ConfigurationDefinitionFixerInterface;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolver;
use PhpCsFixer\FixerConfiguration\FixerOptionBuilder;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use _PhpScoper38a7d00685f8\Symfony\Component\OptionsResolver\Options;
/**
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 * @author SpacePossum
 */
final class FinalInternalClassFixer extends \PhpCsFixer\AbstractFixer implements \PhpCsFixer\Fixer\ConfigurationDefinitionFixerInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(array $configuration = null)
    {
        parent::configure($configuration);
        $intersect = \array_intersect_assoc($this->configuration['annotation-white-list'], $this->configuration['annotation-black-list']);
        if (\count($intersect)) {
            throw new \PhpCsFixer\ConfigurationException\InvalidFixerConfigurationException($this->getName(), \sprintf('Annotation cannot be used in both the white- and black list, got duplicates: "%s".', \implode('", "', \array_keys($intersect))));
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('Internal classes should be `final`.', [new \PhpCsFixer\FixerDefinition\CodeSample("<?php\n/**\n * @internal\n */\nclass Sample\n{\n}\n"), new \PhpCsFixer\FixerDefinition\CodeSample("<?php\n/** @CUSTOM */class A{}\n", ['annotation-white-list' => ['@Custom']])], null, 'Changing classes to `final` might cause code execution to break.');
    }
    /**
     * {@inheritdoc}
     */
    public function isCandidate(\PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        return $tokens->isTokenKindFound(\T_CLASS);
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
    protected function applyFix(\SplFileInfo $file, \PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        for ($index = $tokens->count() - 1; 0 <= $index; --$index) {
            if (!$tokens[$index]->isGivenKind(\T_CLASS) || !$this->isClassCandidate($tokens, $index)) {
                continue;
            }
            // make class final
            $tokens->insertAt($index, [new \PhpCsFixer\Tokenizer\Token([\T_FINAL, 'final']), new \PhpCsFixer\Tokenizer\Token([\T_WHITESPACE, ' '])]);
        }
    }
    /**
     * {@inheritdoc}
     */
    protected function createConfigurationDefinition()
    {
        $annotationsAsserts = [static function (array $values) {
            foreach ($values as $value) {
                if (!\is_string($value) || '' === $value) {
                    return \false;
                }
            }
            return \true;
        }];
        $annotationsNormalizer = static function (\_PhpScoper38a7d00685f8\Symfony\Component\OptionsResolver\Options $options, array $value) {
            $newValue = [];
            foreach ($value as $key) {
                if ('@' === $key[0]) {
                    $key = \substr($key, 1);
                }
                $newValue[\strtolower($key)] = \true;
            }
            return $newValue;
        };
        return new \PhpCsFixer\FixerConfiguration\FixerConfigurationResolver([(new \PhpCsFixer\FixerConfiguration\FixerOptionBuilder('annotation-white-list', 'Class level annotations tags that must be set in order to fix the class. (case insensitive)'))->setAllowedTypes(['array'])->setAllowedValues($annotationsAsserts)->setDefault(['@internal'])->setNormalizer($annotationsNormalizer)->getOption(), (new \PhpCsFixer\FixerConfiguration\FixerOptionBuilder('annotation-black-list', 'Class level annotations tags that must be omitted to fix the class, even if all of the white list ones are used as well. (case insensitive)'))->setAllowedTypes(['array'])->setAllowedValues($annotationsAsserts)->setDefault(['@final', '@Entity', '_PhpScoper38a7d00685f8\\@ORM\\Entity'])->setNormalizer($annotationsNormalizer)->getOption(), (new \PhpCsFixer\FixerConfiguration\FixerOptionBuilder('consider-absent-docblock-as-internal-class', 'Should classes without any DocBlock be fixed to final?'))->setAllowedTypes(['bool'])->setDefault(\false)->getOption()]);
    }
    /**
     * @param int $index T_CLASS index
     *
     * @return bool
     */
    private function isClassCandidate(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        if ($tokens[$tokens->getPrevMeaningfulToken($index)]->isGivenKind([\T_ABSTRACT, \T_FINAL, \T_NEW])) {
            return \false;
            // ignore class; it is abstract or already final
        }
        $docToken = $tokens[$tokens->getPrevNonWhitespace($index)];
        if (!$docToken->isGivenKind(\T_DOC_COMMENT)) {
            return $this->configuration['consider-absent-docblock-as-internal-class'];
        }
        $doc = new \PhpCsFixer\DocBlock\DocBlock($docToken->getContent());
        $tags = [];
        foreach ($doc->getAnnotations() as $annotation) {
            \PhpCsFixer\Preg::match('/@\\S+(?=\\s|$)/', $annotation->getContent(), $matches);
            $tag = \strtolower(\substr(\array_shift($matches), 1));
            foreach ($this->configuration['annotation-black-list'] as $tagStart => $true) {
                if (0 === \strpos($tag, $tagStart)) {
                    return \false;
                    // ignore class: class-level PHPDoc contains tag that has been black listed through configuration
                }
            }
            $tags[$tag] = \true;
        }
        foreach ($this->configuration['annotation-white-list'] as $tag => $true) {
            if (!isset($tags[$tag])) {
                return \false;
                // ignore class: class-level PHPDoc does not contain all tags that has been white listed through configuration
            }
        }
        return \true;
    }
}
