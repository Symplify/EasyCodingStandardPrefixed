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
namespace PhpCsFixer\Fixer\FunctionNotation;

use PhpCsFixer\AbstractPhpdocToTypeDeclarationFixer;
use PhpCsFixer\DocBlock\Annotation;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\FixerDefinition\VersionSpecification;
use PhpCsFixer\FixerDefinition\VersionSpecificCodeSample;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Jan Gantzert <jan@familie-gantzert.de>
 */
final class PhpdocToParamTypeFixer extends AbstractPhpdocToTypeDeclarationFixer
{
    const MINIMUM_PHP_VERSION = 70000;
    /**
     * @var array{int, string}[]
     */
    const EXCLUDE_FUNC_NAMES = [[\T_STRING, '__clone'], [\T_STRING, '__destruct']];
    /**
     * @var array<string, true>
     */
    const SKIPPED_TYPES = ['mixed' => \true, 'resource' => \true, 'static' => \true, 'void' => \true];
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition('EXPERIMENTAL: Takes `@param` annotations of non-mixed types and adjusts accordingly the function signature. Requires PHP >= 7.0.', [new VersionSpecificCodeSample('<?php

/** @param string $bar */
function my_foo($bar)
{}
', new VersionSpecification(70000)), new VersionSpecificCodeSample('<?php

/** @param string|null $bar */
function my_foo($bar)
{}
', new VersionSpecification(70100)), new VersionSpecificCodeSample('<?php

/** @param Foo $foo */
function foo($foo) {}
/** @param string $foo */
function bar($foo) {}
', new VersionSpecification(70100), ['scalar_types' => \false])], null, 'This rule is EXPERIMENTAL and [1] is not covered with backward compatibility promise. [2] `@param` annotation is mandatory for the fixer to make changes, signatures of methods without it (no docblock, inheritdocs) will not be fixed. [3] Manual actions are required if inherited signatures are not properly documented.');
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return \PHP_VERSION_ID >= self::MINIMUM_PHP_VERSION && $tokens->isTokenKindFound(\T_FUNCTION);
    }
    /**
     * {@inheritdoc}
     *
     * Must run before NoSuperfluousPhpdocTagsFixer, PhpdocAlignFixer.
     * Must run after AlignMultilineCommentFixer, CommentToPhpdocFixer, PhpdocIndentFixer, PhpdocScalarFixer, PhpdocToCommentFixer, PhpdocTypesFixer.
     * @return int
     */
    public function getPriority()
    {
        return 8;
    }
    /**
     * @param string $type
     * @return bool
     */
    protected function isSkippedType($type)
    {
        return isset(self::SKIPPED_TYPES[$type]);
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        for ($index = $tokens->count() - 1; 0 < $index; --$index) {
            if (!$tokens[$index]->isGivenKind(\T_FUNCTION)) {
                continue;
            }
            $funcName = $tokens->getNextMeaningfulToken($index);
            if ($tokens[$funcName]->equalsAny(self::EXCLUDE_FUNC_NAMES, \false)) {
                continue;
            }
            $docCommentIndex = $this->findFunctionDocComment($tokens, $index);
            if (null === $docCommentIndex) {
                continue;
            }
            foreach ($this->getAnnotationsFromDocComment('param', $tokens, $docCommentIndex) as $paramTypeAnnotation) {
                $typeInfo = $this->getCommonTypeFromAnnotation($paramTypeAnnotation, \false);
                if (null === $typeInfo) {
                    continue;
                }
                list($paramType, $isNullable) = $typeInfo;
                $startIndex = $tokens->getNextTokenOfKind($index, ['(']);
                $variableIndex = $this->findCorrectVariable($tokens, $startIndex, $paramTypeAnnotation);
                if (null === $variableIndex) {
                    continue;
                }
                $byRefIndex = $tokens->getPrevMeaningfulToken($variableIndex);
                if ($tokens[$byRefIndex]->equals('&')) {
                    $variableIndex = $byRefIndex;
                }
                if ($this->hasParamTypeHint($tokens, $variableIndex)) {
                    continue;
                }
                if (!$this->isValidSyntax(\sprintf('<?php function f(%s $x) {}', $paramType))) {
                    continue;
                }
                $tokens->insertAt($variableIndex, \array_merge($this->createTypeDeclarationTokens($paramType, $isNullable), [new Token([\T_WHITESPACE, ' '])]));
            }
        }
    }
    /**
     * @return int|null
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $startIndex
     * @param \PhpCsFixer\DocBlock\Annotation $paramTypeAnnotation
     */
    private function findCorrectVariable($tokens, $startIndex, $paramTypeAnnotation)
    {
        $endIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $startIndex);
        for ($index = $startIndex + 1; $index < $endIndex; ++$index) {
            if (!$tokens[$index]->isGivenKind(\T_VARIABLE)) {
                continue;
            }
            $variableName = $tokens[$index]->getContent();
            if ($paramTypeAnnotation->getVariableName() === $variableName) {
                return $index;
            }
        }
        return null;
    }
    /**
     * Determine whether the function already has a param type hint.
     *
     * @param int $index The index of the end of the function definition line, EG at { or ;
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    private function hasParamTypeHint($tokens, $index)
    {
        $prevIndex = $tokens->getPrevMeaningfulToken($index);
        return !$tokens[$prevIndex]->equalsAny([',', '(']);
    }
}
