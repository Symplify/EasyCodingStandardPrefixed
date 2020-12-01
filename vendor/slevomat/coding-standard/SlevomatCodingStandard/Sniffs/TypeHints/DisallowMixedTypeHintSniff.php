<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Sniffs\TypeHints;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\Annotation\GenericAnnotation;
use SlevomatCodingStandard\Helpers\AnnotationHelper;
use SlevomatCodingStandard\Helpers\AnnotationTypeHelper;
use SlevomatCodingStandard\Helpers\SuppressHelper;
use function sprintf;
use function strtolower;
use const _PhpScoper9613f3fac51d\T_DOC_COMMENT_OPEN_TAG;
class DisallowMixedTypeHintSniff implements \PHP_CodeSniffer\Sniffs\Sniff
{
    public const CODE_DISALLOWED_MIXED_TYPE_HINT = 'DisallowedMixedTypeHint';
    private const NAME = 'SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint';
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
        if (\SlevomatCodingStandard\Helpers\SuppressHelper::isSniffSuppressed($phpcsFile, $docCommentOpenPointer, $this->getSniffName(self::CODE_DISALLOWED_MIXED_TYPE_HINT))) {
            return;
        }
        $annotations = \SlevomatCodingStandard\Helpers\AnnotationHelper::getAnnotations($phpcsFile, $docCommentOpenPointer);
        foreach ($annotations as $annotationByName) {
            foreach ($annotationByName as $annotation) {
                if ($annotation instanceof \SlevomatCodingStandard\Helpers\Annotation\GenericAnnotation) {
                    continue;
                }
                if ($annotation->isInvalid()) {
                    continue;
                }
                foreach (\SlevomatCodingStandard\Helpers\AnnotationHelper::getAnnotationTypes($annotation) as $annotationType) {
                    foreach (\SlevomatCodingStandard\Helpers\AnnotationTypeHelper::getIdentifierTypeNodes($annotationType) as $typeHintNode) {
                        $typeHint = \SlevomatCodingStandard\Helpers\AnnotationTypeHelper::getTypeHintFromNode($typeHintNode);
                        if (\strtolower($typeHint) !== 'mixed') {
                            continue;
                        }
                        $phpcsFile->addError('Usage of "mixed" type hint is disallowed.', $annotation->getStartPointer(), self::CODE_DISALLOWED_MIXED_TYPE_HINT);
                    }
                }
            }
        }
    }
    private function getSniffName(string $sniffName) : string
    {
        return \sprintf('%s.%s', self::NAME, $sniffName);
    }
}
