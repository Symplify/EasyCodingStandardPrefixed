<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use _PhpScoperb44a315fec16\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode;
use _PhpScoperb44a315fec16\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use SlevomatCodingStandard\Helpers\Annotation\GenericAnnotation;
use SlevomatCodingStandard\Helpers\AnnotationConstantExpressionHelper;
use SlevomatCodingStandard\Helpers\AnnotationHelper;
use SlevomatCodingStandard\Helpers\AnnotationTypeHelper;
use SlevomatCodingStandard\Helpers\ClassHelper;
use SlevomatCodingStandard\Helpers\ConstantHelper;
use SlevomatCodingStandard\Helpers\FunctionHelper;
use SlevomatCodingStandard\Helpers\NamespaceHelper;
use SlevomatCodingStandard\Helpers\ReferencedName;
use SlevomatCodingStandard\Helpers\ReferencedNameHelper;
use SlevomatCodingStandard\Helpers\SniffSettingsHelper;
use SlevomatCodingStandard\Helpers\StringHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use SlevomatCodingStandard\Helpers\TypeHelper;
use SlevomatCodingStandard\Helpers\TypeHintHelper;
use SlevomatCodingStandard\Helpers\UseStatement;
use SlevomatCodingStandard\Helpers\UseStatementHelper;
use stdClass;
use function array_filter;
use function array_flip;
use function array_key_exists;
use function array_map;
use function array_merge;
use function array_reduce;
use function array_values;
use function constant;
use function count;
use function defined;
use function function_exists;
use function in_array;
use function sprintf;
use function strtolower;
use function substr;
use const _PhpScoperb44a315fec16\T_COMMA;
use const T_DECLARE;
use const _PhpScoperb44a315fec16\T_DOC_COMMENT_OPEN_TAG;
use const T_NAMESPACE;
use const _PhpScoperb44a315fec16\T_OPEN_CURLY_BRACKET;
use const T_OPEN_TAG;
use const _PhpScoperb44a315fec16\T_SEMICOLON;
use const T_WHITESPACE;
class ReferenceUsedNamesOnlySniff implements \PHP_CodeSniffer\Sniffs\Sniff
{
    public const CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME = 'ReferenceViaFullyQualifiedName';
    public const CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE = 'ReferenceViaFullyQualifiedNameWithoutNamespace';
    public const CODE_REFERENCE_VIA_FALLBACK_GLOBAL_NAME = 'ReferenceViaFallbackGlobalName';
    public const CODE_PARTIAL_USE = 'PartialUse';
    private const SOURCE_CODE = 1;
    private const SOURCE_ANNOTATION = 2;
    private const SOURCE_ANNOTATION_CONSTANT_FETCH = 3;
    /** @var bool */
    public $searchAnnotations = \false;
    /** @var string[] */
    public $fullyQualifiedKeywords = [];
    /** @var bool */
    public $allowFullyQualifiedExceptions = \false;
    /** @var bool */
    public $allowFullyQualifiedGlobalClasses = \false;
    /** @var bool */
    public $allowFullyQualifiedGlobalFunctions = \false;
    /** @var bool */
    public $allowFallbackGlobalFunctions = \true;
    /** @var bool */
    public $allowFullyQualifiedGlobalConstants = \false;
    /** @var bool */
    public $allowFallbackGlobalConstants = \true;
    /** @var string[] */
    public $specialExceptionNames = [];
    /** @var string[] */
    public $ignoredNames = [];
    /** @var bool */
    public $allowPartialUses = \true;
    /**
     * If empty, all namespaces are required to be used
     *
     * @var string[]
     */
    public $namespacesRequiredToUse = [];
    /** @var bool */
    public $allowFullyQualifiedNameForCollidingClasses = \false;
    /** @var bool */
    public $allowFullyQualifiedNameForCollidingFunctions = \false;
    /** @var bool */
    public $allowFullyQualifiedNameForCollidingConstants = \false;
    /** @var string[]|null */
    private $normalizedFullyQualifiedKeywords;
    /** @var string[]|null */
    private $normalizedSpecialExceptionNames;
    /** @var string[]|null */
    private $normalizedIgnoredNames;
    /** @var string[]|null */
    private $normalizedNamespacesRequiredToUse;
    /**
     * @return array<int, (int|string)>
     */
    public function register() : array
    {
        return [\T_OPEN_TAG];
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param File $phpcsFile
     * @param int $openTagPointer
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $openTagPointer) : void
    {
        if (\SlevomatCodingStandard\Helpers\TokenHelper::findPrevious($phpcsFile, \T_OPEN_TAG, $openTagPointer - 1) !== null) {
            return;
        }
        $tokens = $phpcsFile->getTokens();
        $references = $this->getReferences($phpcsFile, $openTagPointer);
        $definedClassesIndex = [];
        foreach (\SlevomatCodingStandard\Helpers\ClassHelper::getAllNames($phpcsFile) as $definedClassPointer => $definedClassName) {
            $definedClassesIndex[\strtolower($definedClassName)] = \SlevomatCodingStandard\Helpers\NamespaceHelper::resolveClassName($phpcsFile, $definedClassName, $definedClassPointer);
        }
        $definedFunctionsIndex = \array_flip(\array_map(static function (string $functionName) : string {
            return \strtolower($functionName);
        }, \SlevomatCodingStandard\Helpers\FunctionHelper::getAllFunctionNames($phpcsFile)));
        $definedConstantsIndex = \array_flip(\SlevomatCodingStandard\Helpers\ConstantHelper::getAllNames($phpcsFile));
        $classReferencesIndex = [];
        if ($this->allowFullyQualifiedNameForCollidingClasses) {
            $classReferences = \array_filter($references, static function (\stdClass $reference) : bool {
                return $reference->source === self::SOURCE_CODE && $reference->isClass;
            });
            foreach ($classReferences as $classReference) {
                $classReferencesIndex[\strtolower($classReference->name)] = \SlevomatCodingStandard\Helpers\NamespaceHelper::resolveName($phpcsFile, $classReference->name, $classReference->type, $classReference->startPointer);
            }
        }
        $namespacePointers = \SlevomatCodingStandard\Helpers\NamespaceHelper::getAllNamespacesPointers($phpcsFile);
        $referenceErrors = [];
        foreach ($references as $reference) {
            $useStatements = \SlevomatCodingStandard\Helpers\UseStatementHelper::getUseStatementsForPointer($phpcsFile, $reference->startPointer);
            $name = $reference->name;
            /** @var int $startPointer */
            $startPointer = $reference->startPointer;
            $canonicalName = \SlevomatCodingStandard\Helpers\NamespaceHelper::normalizeToCanonicalName($name);
            $unqualifiedName = \SlevomatCodingStandard\Helpers\NamespaceHelper::getUnqualifiedNameFromFullyQualifiedName($name);
            $isFullyQualified = \SlevomatCodingStandard\Helpers\NamespaceHelper::isFullyQualifiedName($name);
            $isGlobalFallback = !$isFullyQualified && !\SlevomatCodingStandard\Helpers\NamespaceHelper::hasNamespace($name) && $namespacePointers !== [] && !\array_key_exists(\SlevomatCodingStandard\Helpers\UseStatement::getUniqueId($reference->type, $name), $useStatements);
            $isGlobalFunctionFallback = \false;
            if ($reference->isFunction && $isGlobalFallback) {
                $isGlobalFunctionFallback = !\array_key_exists(\strtolower($reference->name), $definedFunctionsIndex) && \function_exists($reference->name);
            }
            $isGlobalConstantFallback = \false;
            if ($reference->isConstant && $isGlobalFallback) {
                $isGlobalConstantFallback = !\array_key_exists($reference->name, $definedConstantsIndex) && \defined($reference->name);
            }
            if ($isFullyQualified) {
                if ($reference->isClass && $this->allowFullyQualifiedNameForCollidingClasses) {
                    $lowerCasedUnqualifiedClassName = \strtolower($unqualifiedName);
                    if (\array_key_exists($lowerCasedUnqualifiedClassName, $definedClassesIndex) && $canonicalName !== \SlevomatCodingStandard\Helpers\NamespaceHelper::normalizeToCanonicalName($definedClassesIndex[$lowerCasedUnqualifiedClassName])) {
                        continue;
                    }
                    if (\array_key_exists($lowerCasedUnqualifiedClassName, $classReferencesIndex) && $name !== $classReferencesIndex[$lowerCasedUnqualifiedClassName]) {
                        continue;
                    }
                    if (\array_key_exists($lowerCasedUnqualifiedClassName, $useStatements) && $canonicalName !== \SlevomatCodingStandard\Helpers\NamespaceHelper::normalizeToCanonicalName($useStatements[$lowerCasedUnqualifiedClassName]->getFullyQualifiedTypeName())) {
                        continue;
                    }
                } elseif ($reference->isFunction && $this->allowFullyQualifiedNameForCollidingFunctions) {
                    $lowerCasedUnqualifiedFunctionName = \strtolower($unqualifiedName);
                    if (\array_key_exists($lowerCasedUnqualifiedFunctionName, $definedFunctionsIndex)) {
                        continue;
                    }
                } elseif ($reference->isConstant && $this->allowFullyQualifiedNameForCollidingConstants) {
                    if (\array_key_exists($unqualifiedName, $definedConstantsIndex)) {
                        continue;
                    }
                }
            }
            if ($isFullyQualified || $isGlobalFunctionFallback || $isGlobalConstantFallback) {
                if ($isFullyQualified && !$this->isRequiredToBeUsed($name)) {
                    continue;
                }
                $isExceptionByName = \SlevomatCodingStandard\Helpers\StringHelper::endsWith($name, 'Exception') || $name === '\\Throwable' || \SlevomatCodingStandard\Helpers\StringHelper::endsWith($name, 'Error') && !\SlevomatCodingStandard\Helpers\NamespaceHelper::hasNamespace($name) || \in_array($canonicalName, $this->getSpecialExceptionNames(), \true);
                $inIgnoredNames = \in_array($canonicalName, $this->getIgnoredNames(), \true);
                if ($isExceptionByName && !$inIgnoredNames && $this->allowFullyQualifiedExceptions) {
                    continue;
                }
                $previousKeywordPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findPreviousExcluding($phpcsFile, \array_merge(\SlevomatCodingStandard\Helpers\TokenHelper::getNameTokenCodes(), [\T_WHITESPACE, \T_COMMA]), $startPointer - 1);
                if (!\in_array($tokens[$previousKeywordPointer]['code'], $this->getFullyQualifiedKeywords(), \true)) {
                    if ($isFullyQualified && !\SlevomatCodingStandard\Helpers\NamespaceHelper::hasNamespace($name) && $namespacePointers === []) {
                        $label = \sprintf($reference->isConstant ? 'Constant %s' : ($reference->isFunction ? 'Function %s()' : 'Class %s'), $name);
                        $fix = $phpcsFile->addFixableError(\sprintf('%s should not be referenced via a fully qualified name, but via an unqualified name without the leading \\, because the file does not have a namespace and the type cannot be put in a use statement.', $label), $startPointer, self::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE);
                        if ($fix) {
                            $phpcsFile->fixer->beginChangeset();
                            if ($reference->source === self::SOURCE_ANNOTATION) {
                                $fixedAnnotationContent = \SlevomatCodingStandard\Helpers\AnnotationHelper::fixAnnotationType($phpcsFile, $reference->annotation, $reference->nameNode, new \_PhpScoperb44a315fec16\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode(\substr($reference->name, 1)));
                                $phpcsFile->fixer->replaceToken($startPointer, $fixedAnnotationContent);
                                for ($i = $startPointer + 1; $i <= $reference->endPointer; $i++) {
                                    $phpcsFile->fixer->replaceToken($i, '');
                                }
                            } elseif ($reference->source === self::SOURCE_ANNOTATION_CONSTANT_FETCH) {
                                $fixedAnnotationContent = \SlevomatCodingStandard\Helpers\AnnotationHelper::fixAnnotationConstantFetchNode($phpcsFile, $reference->annotation, $reference->constantFetchNode, new \_PhpScoperb44a315fec16\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode(\substr($reference->name, 1), $reference->constantFetchNode->name));
                                $phpcsFile->fixer->replaceToken($startPointer, $fixedAnnotationContent);
                                for ($i = $startPointer + 1; $i <= $reference->endPointer; $i++) {
                                    $phpcsFile->fixer->replaceToken($i, '');
                                }
                            } else {
                                $phpcsFile->fixer->replaceToken($startPointer, \substr($tokens[$startPointer]['content'], 1));
                            }
                            $phpcsFile->fixer->endChangeset();
                        }
                    } else {
                        $shouldBeUsed = \SlevomatCodingStandard\Helpers\NamespaceHelper::hasNamespace($name);
                        if (!$shouldBeUsed) {
                            if ($reference->isFunction) {
                                $shouldBeUsed = $isFullyQualified ? !$this->allowFullyQualifiedGlobalFunctions : !$this->allowFallbackGlobalFunctions;
                            } elseif ($reference->isConstant) {
                                $shouldBeUsed = $isFullyQualified ? !$this->allowFullyQualifiedGlobalConstants : !$this->allowFallbackGlobalConstants;
                            } else {
                                $shouldBeUsed = !$this->allowFullyQualifiedGlobalClasses;
                            }
                        }
                        if (!$shouldBeUsed) {
                            continue;
                        }
                        $referenceErrors[] = (object) ['reference' => $reference, 'canonicalName' => $canonicalName, 'isGlobalConstantFallback' => $isGlobalConstantFallback, 'isGlobalFunctionFallback' => $isGlobalFunctionFallback];
                    }
                }
            } elseif (!$this->allowPartialUses) {
                if (\SlevomatCodingStandard\Helpers\NamespaceHelper::isQualifiedName($name)) {
                    $phpcsFile->addError(\sprintf('Partial use statements are not allowed, but referencing %s found.', $name), $startPointer, self::CODE_PARTIAL_USE);
                }
            }
        }
        if (\count($referenceErrors) === 0) {
            return;
        }
        $alreadyAddedUses = [\SlevomatCodingStandard\Helpers\UseStatement::TYPE_DEFAULT => [], \SlevomatCodingStandard\Helpers\UseStatement::TYPE_FUNCTION => [], \SlevomatCodingStandard\Helpers\UseStatement::TYPE_CONSTANT => []];
        $phpcsFile->fixer->beginChangeset();
        foreach ($referenceErrors as $referenceData) {
            $reference = $referenceData->reference;
            /** @var int $startPointer */
            $startPointer = $reference->startPointer;
            $canonicalName = $referenceData->canonicalName;
            $nameToReference = \SlevomatCodingStandard\Helpers\NamespaceHelper::getUnqualifiedNameFromFullyQualifiedName($reference->name);
            $canonicalNameToReference = $reference->isConstant ? $nameToReference : \strtolower($nameToReference);
            $isGlobalConstantFallback = $referenceData->isGlobalConstantFallback;
            $isGlobalFunctionFallback = $referenceData->isGlobalFunctionFallback;
            $useStatements = \SlevomatCodingStandard\Helpers\UseStatementHelper::getUseStatementsForPointer($phpcsFile, $reference->startPointer);
            $canBeFixed = \array_reduce($alreadyAddedUses[$reference->type], static function (bool $carry, string $use) use($canonicalName) : bool {
                return \SlevomatCodingStandard\Helpers\NamespaceHelper::getLastNamePart($use) === \SlevomatCodingStandard\Helpers\NamespaceHelper::getLastNamePart($canonicalName) ? \false : $carry;
            }, \true);
            foreach ($useStatements as $useStatement) {
                if ($useStatement->getType() !== $reference->type) {
                    continue;
                }
                if ($useStatement->getFullyQualifiedTypeName() === $canonicalName) {
                    continue;
                }
                if (!($useStatement->getCanonicalNameAsReferencedInFile() === $canonicalNameToReference || $reference->isClass && \array_key_exists($canonicalNameToReference, $definedClassesIndex) && $canonicalName !== \SlevomatCodingStandard\Helpers\NamespaceHelper::normalizeToCanonicalName($definedClassesIndex[$canonicalNameToReference]) || $reference->isFunction && \array_key_exists($canonicalNameToReference, $definedFunctionsIndex) || $reference->isConstant && \array_key_exists($canonicalNameToReference, $definedConstantsIndex))) {
                    continue;
                }
                $canBeFixed = \false;
                break;
            }
            $label = \sprintf($reference->isConstant ? 'Constant %s' : ($reference->isFunction ? 'Function %s()' : 'Class %s'), $reference->name);
            $errorCode = $isGlobalConstantFallback || $isGlobalFunctionFallback ? self::CODE_REFERENCE_VIA_FALLBACK_GLOBAL_NAME : self::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME;
            $errorMessage = $isGlobalConstantFallback || $isGlobalFunctionFallback ? \sprintf('%s should not be referenced via a fallback global name, but via a use statement.', $label) : \sprintf('%s should not be referenced via a fully qualified name, but via a use statement.', $label);
            if (!$canBeFixed) {
                $phpcsFile->addError($errorMessage, $startPointer, $errorCode);
                continue;
            }
            $fix = $phpcsFile->addFixableError($errorMessage, $startPointer, $errorCode);
            if (!$fix) {
                continue;
            }
            $addUse = !\in_array($canonicalName, $alreadyAddedUses[$reference->type], \true);
            if ($reference->isClass && \array_key_exists($canonicalNameToReference, $definedClassesIndex)) {
                $addUse = \false;
            }
            foreach ($useStatements as $useStatement) {
                if ($useStatement->getType() !== $reference->type || $useStatement->getFullyQualifiedTypeName() !== $canonicalName) {
                    continue;
                }
                $nameToReference = $useStatement->getNameAsReferencedInFile();
                $addUse = \false;
                break;
            }
            if ($addUse) {
                $useStatementPlacePointer = $this->getUseStatementPlacePointer($phpcsFile, $openTagPointer, $useStatements);
                $useTypeName = \SlevomatCodingStandard\Helpers\UseStatement::getTypeName($reference->type);
                $useTypeFormatted = $useTypeName !== null ? \sprintf('%s ', $useTypeName) : '';
                $phpcsFile->fixer->addNewline($useStatementPlacePointer);
                $phpcsFile->fixer->addContent($useStatementPlacePointer, \sprintf('use %s%s;', $useTypeFormatted, $canonicalName));
                $alreadyAddedUses[$reference->type][] = $canonicalName;
            }
            if ($reference->source === self::SOURCE_ANNOTATION) {
                $fixedAnnotationContent = \SlevomatCodingStandard\Helpers\AnnotationHelper::fixAnnotationType($phpcsFile, $reference->annotation, $reference->nameNode, new \_PhpScoperb44a315fec16\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($nameToReference));
                $phpcsFile->fixer->replaceToken($startPointer, $fixedAnnotationContent);
            } elseif ($reference->source === self::SOURCE_ANNOTATION_CONSTANT_FETCH) {
                $fixedAnnotationContent = \SlevomatCodingStandard\Helpers\AnnotationHelper::fixAnnotationConstantFetchNode($phpcsFile, $reference->annotation, $reference->constantFetchNode, new \_PhpScoperb44a315fec16\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode($nameToReference, $reference->constantFetchNode->name));
                $phpcsFile->fixer->replaceToken($startPointer, $fixedAnnotationContent);
            } else {
                $phpcsFile->fixer->replaceToken($startPointer, $nameToReference);
            }
            for ($i = $startPointer + 1; $i <= $reference->endPointer; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }
        }
        $phpcsFile->fixer->endChangeset();
    }
    /**
     * @return string[]
     */
    private function getSpecialExceptionNames() : array
    {
        if ($this->normalizedSpecialExceptionNames === null) {
            $this->normalizedSpecialExceptionNames = \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeArray($this->specialExceptionNames);
        }
        return $this->normalizedSpecialExceptionNames;
    }
    /**
     * @return string[]
     */
    private function getIgnoredNames() : array
    {
        if ($this->normalizedIgnoredNames === null) {
            $this->normalizedIgnoredNames = \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeArray($this->ignoredNames);
        }
        return $this->normalizedIgnoredNames;
    }
    /**
     * @return string[]
     */
    private function getNamespacesRequiredToUse() : array
    {
        if ($this->normalizedNamespacesRequiredToUse === null) {
            $this->normalizedNamespacesRequiredToUse = \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeArray($this->namespacesRequiredToUse);
        }
        return $this->normalizedNamespacesRequiredToUse;
    }
    /**
     * @return string[]
     */
    private function getFullyQualifiedKeywords() : array
    {
        if ($this->normalizedFullyQualifiedKeywords === null) {
            $this->normalizedFullyQualifiedKeywords = \array_map(static function (string $keyword) {
                if (!\defined($keyword)) {
                    throw new \SlevomatCodingStandard\Sniffs\Namespaces\UndefinedKeywordTokenException($keyword);
                }
                return \constant($keyword);
            }, \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeArray($this->fullyQualifiedKeywords));
        }
        return $this->normalizedFullyQualifiedKeywords;
    }
    /**
     * @param File $phpcsFile
     * @param int $openTagPointer
     * @param UseStatement[] $useStatements
     * @return int
     */
    private function getUseStatementPlacePointer(\PHP_CodeSniffer\Files\File $phpcsFile, int $openTagPointer, array $useStatements) : int
    {
        if (\count($useStatements) !== 0) {
            $lastUseStatement = \array_values($useStatements)[\count($useStatements) - 1];
            /** @var int $useStatementPlacePointer */
            $useStatementPlacePointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_SEMICOLON, $lastUseStatement->getPointer() + 1);
            return $useStatementPlacePointer;
        }
        $namespacePointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_NAMESPACE, $openTagPointer + 1);
        if ($namespacePointer !== null) {
            /** @var int $useStatementPlacePointer */
            $useStatementPlacePointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, [\T_SEMICOLON, \T_OPEN_CURLY_BRACKET], $namespacePointer + 1);
            return $useStatementPlacePointer;
        }
        $pointerAfterOpenTagPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $openTagPointer + 1);
        if ($phpcsFile->getTokens()[$pointerAfterOpenTagPointer]['code'] === \T_DECLARE) {
            /** @var int $useStatementPlacePointer */
            $useStatementPlacePointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_SEMICOLON, $pointerAfterOpenTagPointer + 1);
            return $useStatementPlacePointer;
        }
        return $openTagPointer;
    }
    private function isRequiredToBeUsed(string $name) : bool
    {
        if (\count($this->namespacesRequiredToUse) === 0) {
            return \true;
        }
        foreach ($this->getNamespacesRequiredToUse() as $namespace) {
            if (!\SlevomatCodingStandard\Helpers\NamespaceHelper::isTypeInNamespace($name, $namespace)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    /**
     * @param File $phpcsFile
     * @param int $openTagPointer
     * @return stdClass[]
     */
    private function getReferences(\PHP_CodeSniffer\Files\File $phpcsFile, int $openTagPointer) : array
    {
        $tokens = $phpcsFile->getTokens();
        $references = [];
        foreach (\SlevomatCodingStandard\Helpers\ReferencedNameHelper::getAllReferencedNames($phpcsFile, $openTagPointer) as $referencedName) {
            $reference = new \stdClass();
            $reference->source = self::SOURCE_CODE;
            $reference->name = $referencedName->getNameAsReferencedInFile();
            $reference->type = $referencedName->getType();
            $reference->startPointer = $referencedName->getStartPointer();
            $reference->endPointer = $referencedName->getEndPointer();
            $reference->isClass = $referencedName->isClass();
            $reference->isConstant = $referencedName->isConstant();
            $reference->isFunction = $referencedName->isFunction();
            $references[] = $reference;
        }
        if (!$this->searchAnnotations) {
            return $references;
        }
        $searchAnnotationsPointer = $openTagPointer + 1;
        while (\true) {
            $docCommentOpenPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_DOC_COMMENT_OPEN_TAG, $searchAnnotationsPointer);
            if ($docCommentOpenPointer === null) {
                break;
            }
            $annotations = \SlevomatCodingStandard\Helpers\AnnotationHelper::getAnnotations($phpcsFile, $docCommentOpenPointer);
            foreach ($annotations as $annotationsByName) {
                foreach ($annotationsByName as $annotation) {
                    if ($annotation instanceof \SlevomatCodingStandard\Helpers\Annotation\GenericAnnotation) {
                        continue;
                    }
                    if ($annotation->isInvalid()) {
                        continue;
                    }
                    foreach (\SlevomatCodingStandard\Helpers\AnnotationHelper::getAnnotationTypes($annotation) as $annotationType) {
                        foreach (\SlevomatCodingStandard\Helpers\AnnotationTypeHelper::getIdentifierTypeNodes($annotationType) as $typeHintNode) {
                            $typeHint = \SlevomatCodingStandard\Helpers\AnnotationTypeHelper::getTypeHintFromNode($typeHintNode);
                            $lowercasedTypeHint = \strtolower($typeHint);
                            if (\SlevomatCodingStandard\Helpers\TypeHintHelper::isSimpleTypeHint($lowercasedTypeHint) || \SlevomatCodingStandard\Helpers\TypeHintHelper::isSimpleUnofficialTypeHints($lowercasedTypeHint) || !\SlevomatCodingStandard\Helpers\TypeHelper::isTypeName($typeHint)) {
                                continue;
                            }
                            $reference = new \stdClass();
                            $reference->source = self::SOURCE_ANNOTATION;
                            $reference->annotation = $annotation;
                            $reference->nameNode = $typeHintNode;
                            $reference->name = $typeHint;
                            $reference->type = \SlevomatCodingStandard\Helpers\ReferencedName::TYPE_DEFAULT;
                            $reference->startPointer = $annotation->getStartPointer();
                            $reference->endPointer = $annotation->getEndPointer();
                            $reference->isClass = \true;
                            $reference->isConstant = \false;
                            $reference->isFunction = \false;
                            $references[] = $reference;
                        }
                    }
                    foreach (\SlevomatCodingStandard\Helpers\AnnotationHelper::getAnnotationConstantExpressions($annotation) as $constantExpression) {
                        foreach (\SlevomatCodingStandard\Helpers\AnnotationConstantExpressionHelper::getConstantFetchNodes($constantExpression) as $constantFetchNode) {
                            $reference = new \stdClass();
                            $reference->source = self::SOURCE_ANNOTATION_CONSTANT_FETCH;
                            $reference->annotation = $annotation;
                            $reference->constantFetchNode = $constantFetchNode;
                            $reference->name = $constantFetchNode->className;
                            $reference->type = \SlevomatCodingStandard\Helpers\ReferencedName::TYPE_DEFAULT;
                            $reference->startPointer = $annotation->getStartPointer();
                            $reference->endPointer = $annotation->getEndPointer();
                            $reference->isClass = \true;
                            $reference->isConstant = \false;
                            $reference->isFunction = \false;
                            $references[] = $reference;
                        }
                    }
                }
            }
            $searchAnnotationsPointer = $tokens[$docCommentOpenPointer]['comment_closer'] + 1;
        }
        return $references;
    }
}
