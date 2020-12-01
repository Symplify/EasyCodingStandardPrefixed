<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Sniffs\PHP;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use _PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use _PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode;
use _PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use SlevomatCodingStandard\Helpers\Annotation\VariableAnnotation;
use SlevomatCodingStandard\Helpers\AnnotationHelper;
use SlevomatCodingStandard\Helpers\IndentationHelper;
use SlevomatCodingStandard\Helpers\ScopeHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use SlevomatCodingStandard\Helpers\TypeHintHelper;
use function array_key_exists;
use function array_merge;
use function array_reverse;
use function array_unique;
use function count;
use function implode;
use function in_array;
use function sprintf;
use function trim;
use const T_AS;
use const _PhpScoper9613f3fac51d\T_DOC_COMMENT_OPEN_TAG;
use const _PhpScoper9613f3fac51d\T_EQUAL;
use const T_FOREACH;
use const T_LIST;
use const _PhpScoper9613f3fac51d\T_OPEN_SHORT_ARRAY;
use const _PhpScoper9613f3fac51d\T_SEMICOLON;
use const T_VARIABLE;
use const T_WHILE;
use const T_WHITESPACE;
class RequireExplicitAssertionSniff implements \PHP_CodeSniffer\Sniffs\Sniff
{
    public const CODE_REQUIRED_EXPLICIT_ASSERTION = 'RequiredExplicitAssertion';
    /**
     * @return array<int, (int|string)>
     */
    public function register() : array
    {
        return [\T_DOC_COMMENT_OPEN_TAG];
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param File $phpcsFile
     * @param int $docCommentOpenPointer
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $docCommentOpenPointer) : void
    {
        $tokens = $phpcsFile->getTokens();
        $tokenCodes = [\T_VARIABLE, \T_FOREACH, \T_WHILE, \T_LIST, \T_OPEN_SHORT_ARRAY];
        $commentClosePointer = $tokens[$docCommentOpenPointer]['comment_closer'];
        $codePointer = \SlevomatCodingStandard\Helpers\TokenHelper::findFirstNonWhitespaceOnNextLine($phpcsFile, $commentClosePointer);
        if ($codePointer === null || !\in_array($tokens[$codePointer]['code'], $tokenCodes, \true)) {
            $firstPointerOnPreviousLine = \SlevomatCodingStandard\Helpers\TokenHelper::findFirstNonWhitespaceOnPreviousLine($phpcsFile, $docCommentOpenPointer);
            if ($firstPointerOnPreviousLine === null || !\in_array($tokens[$firstPointerOnPreviousLine]['code'], $tokenCodes, \true)) {
                return;
            }
            $codePointer = $firstPointerOnPreviousLine;
        }
        $variableAnnotations = \SlevomatCodingStandard\Helpers\AnnotationHelper::getAnnotationsByName($phpcsFile, $docCommentOpenPointer, '@var');
        if (\count($variableAnnotations) === 0) {
            return;
        }
        /** @var VariableAnnotation $variableAnnotation */
        foreach (\array_reverse($variableAnnotations) as $variableAnnotation) {
            if ($variableAnnotation->isInvalid()) {
                continue;
            }
            if ($variableAnnotation->getVariableName() === null) {
                continue;
            }
            $variableAnnotationType = $variableAnnotation->getType();
            if ($variableAnnotationType instanceof \_PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode || $variableAnnotationType instanceof \_PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode) {
                foreach ($variableAnnotationType->types as $typeNode) {
                    if (!$this->isValidTypeNode($typeNode)) {
                        continue 2;
                    }
                }
            } elseif (!$this->isValidTypeNode($variableAnnotationType)) {
                continue;
            }
            if ($tokens[$codePointer]['code'] === \T_VARIABLE) {
                $pointerAfterVariable = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $codePointer + 1);
                if ($tokens[$pointerAfterVariable]['code'] !== \T_EQUAL) {
                    continue;
                }
                if ($variableAnnotation->getVariableName() !== $tokens[$codePointer]['content']) {
                    continue;
                }
                $pointerToAddAssertion = $this->getNextSemicolonInSameScope($phpcsFile, $codePointer, $codePointer + 1);
                $indentation = \SlevomatCodingStandard\Helpers\IndentationHelper::getIndentation($phpcsFile, $docCommentOpenPointer);
            } elseif ($tokens[$codePointer]['code'] === \T_LIST) {
                $listParenthesisOpener = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $codePointer + 1);
                $variablePointerInList = \SlevomatCodingStandard\Helpers\TokenHelper::findNextContent($phpcsFile, \T_VARIABLE, $variableAnnotation->getVariableName(), $listParenthesisOpener + 1, $tokens[$listParenthesisOpener]['parenthesis_closer']);
                if ($variablePointerInList === null) {
                    continue;
                }
                $pointerToAddAssertion = $this->getNextSemicolonInSameScope($phpcsFile, $codePointer, $codePointer + 1);
                $indentation = \SlevomatCodingStandard\Helpers\IndentationHelper::getIndentation($phpcsFile, $docCommentOpenPointer);
            } elseif ($tokens[$codePointer]['code'] === \T_OPEN_SHORT_ARRAY) {
                $pointerAfterList = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $tokens[$codePointer]['bracket_closer'] + 1);
                if ($tokens[$pointerAfterList]['code'] !== \T_EQUAL) {
                    continue;
                }
                $variablePointerInList = \SlevomatCodingStandard\Helpers\TokenHelper::findNextContent($phpcsFile, \T_VARIABLE, $variableAnnotation->getVariableName(), $codePointer + 1, $tokens[$codePointer]['bracket_closer']);
                if ($variablePointerInList === null) {
                    continue;
                }
                $pointerToAddAssertion = $this->getNextSemicolonInSameScope($phpcsFile, $codePointer, $tokens[$codePointer]['bracket_closer'] + 1);
                $indentation = \SlevomatCodingStandard\Helpers\IndentationHelper::getIndentation($phpcsFile, $docCommentOpenPointer);
            } else {
                if ($tokens[$codePointer]['code'] === \T_WHILE) {
                    $variablePointerInWhile = \SlevomatCodingStandard\Helpers\TokenHelper::findNextContent($phpcsFile, \T_VARIABLE, $variableAnnotation->getVariableName(), $tokens[$codePointer]['parenthesis_opener'] + 1, $tokens[$codePointer]['parenthesis_closer']);
                    if ($variablePointerInWhile === null) {
                        continue;
                    }
                    $pointerAfterVariableInWhile = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $variablePointerInWhile + 1);
                    if ($tokens[$pointerAfterVariableInWhile]['code'] !== \T_EQUAL) {
                        continue;
                    }
                } else {
                    $asPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_AS, $tokens[$codePointer]['parenthesis_opener'] + 1, $tokens[$codePointer]['parenthesis_closer']);
                    $variablePointerInForeach = \SlevomatCodingStandard\Helpers\TokenHelper::findNextContent($phpcsFile, \T_VARIABLE, $variableAnnotation->getVariableName(), $asPointer + 1, $tokens[$codePointer]['parenthesis_closer']);
                    if ($variablePointerInForeach === null) {
                        continue;
                    }
                }
                $pointerToAddAssertion = $tokens[$codePointer]['scope_opener'];
                $indentation = \SlevomatCodingStandard\Helpers\IndentationHelper::addIndentation(\SlevomatCodingStandard\Helpers\IndentationHelper::getIndentation($phpcsFile, $codePointer));
            }
            $fix = $phpcsFile->addFixableError('Use assertion instead of inline documentation comment.', $variableAnnotation->getStartPointer(), self::CODE_REQUIRED_EXPLICIT_ASSERTION);
            if (!$fix) {
                continue;
            }
            $phpcsFile->fixer->beginChangeset();
            for ($i = $variableAnnotation->getStartPointer(); $i <= $variableAnnotation->getEndPointer(); $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }
            $docCommentUseful = \false;
            $docCommentClosePointer = $tokens[$docCommentOpenPointer]['comment_closer'];
            for ($i = $docCommentOpenPointer + 1; $i < $docCommentClosePointer; $i++) {
                $tokenContent = \trim($phpcsFile->fixer->getTokenContent($i));
                if ($tokenContent === '' || $tokenContent === '*') {
                    continue;
                }
                $docCommentUseful = \true;
                break;
            }
            $pointerBeforeDocComment = \SlevomatCodingStandard\Helpers\TokenHelper::findPreviousContent($phpcsFile, \T_WHITESPACE, $phpcsFile->eolChar, $docCommentOpenPointer - 1);
            $pointerAfterDocComment = \SlevomatCodingStandard\Helpers\TokenHelper::findNextContent($phpcsFile, \T_WHITESPACE, $phpcsFile->eolChar, $docCommentClosePointer + 1);
            if (!$docCommentUseful) {
                for ($i = $pointerBeforeDocComment + 1; $i <= $pointerAfterDocComment; $i++) {
                    $phpcsFile->fixer->replaceToken($i, '');
                }
            }
            /** @var IdentifierTypeNode|ThisTypeNode|UnionTypeNode $variableAnnotationType */
            $variableAnnotationType = $variableAnnotationType;
            $assertion = $this->createAssert($variableAnnotation->getVariableName(), $variableAnnotationType);
            if ($pointerToAddAssertion < $docCommentClosePointer && \array_key_exists($pointerAfterDocComment + 1, $tokens)) {
                $phpcsFile->fixer->addContentBefore($pointerAfterDocComment + 1, $indentation . $assertion . $phpcsFile->eolChar);
            } else {
                $phpcsFile->fixer->addContent($pointerToAddAssertion, $phpcsFile->eolChar . $indentation . $assertion);
            }
            $phpcsFile->fixer->endChangeset();
        }
    }
    private function isValidTypeNode(\_PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode) : bool
    {
        if ($typeNode instanceof \_PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode) {
            return \true;
        }
        if (!$typeNode instanceof \_PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return \false;
        }
        return !\in_array($typeNode->name, ['mixed', 'static'], \true);
    }
    private function getNextSemicolonInSameScope(\PHP_CodeSniffer\Files\File $phpcsFile, int $scopePointer, int $searchAt) : int
    {
        $semicolonPointer = null;
        do {
            $semicolonPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_SEMICOLON, $searchAt);
            if (\SlevomatCodingStandard\Helpers\ScopeHelper::isInSameScope($phpcsFile, $scopePointer, $semicolonPointer)) {
                break;
            }
            $searchAt = $semicolonPointer + 1;
        } while (\true);
        return $semicolonPointer;
    }
    /**
     * @param string $variableName
     * @param IdentifierTypeNode|ThisTypeNode|UnionTypeNode|IntersectionTypeNode $typeNode
     * @return string
     */
    private function createAssert(string $variableName, \_PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode) : string
    {
        $conditions = [];
        if ($typeNode instanceof \_PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode || $typeNode instanceof \_PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode) {
            $conditions = $this->createConditions($variableName, $typeNode);
        } else {
            /** @var IdentifierTypeNode|ThisTypeNode $innerTypeNode */
            foreach ($typeNode->types as $innerTypeNode) {
                $conditions = \array_merge($conditions, $this->createConditions($variableName, $innerTypeNode));
            }
        }
        $operator = $typeNode instanceof \_PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode ? '&&' : '||';
        return \sprintf('\\assert(%s);', \implode(\sprintf(' %s ', $operator), \array_unique($conditions)));
    }
    /**
     * @param string $variableName
     * @param IdentifierTypeNode|ThisTypeNode $typeNode
     * @return string[]
     */
    private function createConditions(string $variableName, \_PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode) : array
    {
        if ($typeNode instanceof \_PhpScoper9613f3fac51d\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode) {
            return [\sprintf('%s instanceof $this', $variableName)];
        }
        if ($typeNode->name === 'self') {
            return [\sprintf('%s instanceof %s', $variableName, $typeNode->name)];
        }
        if (\SlevomatCodingStandard\Helpers\TypeHintHelper::isSimpleTypeHint($typeNode->name)) {
            return [\sprintf('\\is_%s(%s)', $typeNode->name, $variableName)];
        }
        if (\in_array($typeNode->name, ['resource', 'object'], \true)) {
            return [\sprintf('\\is_%s(%s)', $typeNode->name, $variableName)];
        }
        if (\in_array($typeNode->name, ['true', 'false', 'null'], \true)) {
            return [\sprintf('%s === %s', $variableName, $typeNode->name)];
        }
        if ($typeNode->name === 'numeric') {
            return [\sprintf('\\is_int(%s)', $variableName), \sprintf('\\is_float(%s)', $variableName)];
        }
        if ($typeNode->name === 'scalar') {
            return [\sprintf('\\is_int(%s)', $variableName), \sprintf('\\is_float(%s)', $variableName), \sprintf('\\is_bool(%s)', $variableName), \sprintf('\\is_string(%s)', $variableName)];
        }
        return [\sprintf('%s instanceof %s', $variableName, $typeNode->name)];
    }
}
