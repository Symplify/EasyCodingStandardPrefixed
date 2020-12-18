<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\ClassHelper;
use SlevomatCodingStandard\Helpers\SniffSettingsHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use function assert;
use function in_array;
use function str_repeat;
use const T_COMMENT;
use const T_CONST;
use const _PhpScoper4d3fa30a680b\T_DOC_COMMENT_OPEN_TAG;
use const T_FUNCTION;
use const T_PRIVATE;
use const T_PROTECTED;
use const T_PUBLIC;
use const _PhpScoper4d3fa30a680b\T_SEMICOLON;
use const T_USE;
use const T_VAR;
use const T_VARIABLE;
/**
 * @internal
 */
abstract class AbstractPropertyAndConstantSpacing implements \PHP_CodeSniffer\Sniffs\Sniff
{
    /** @var int */
    public $minLinesCountBeforeWithComment = 1;
    /** @var int */
    public $maxLinesCountBeforeWithComment = 1;
    /** @var int */
    public $minLinesCountBeforeWithoutComment = 0;
    /** @var int */
    public $maxLinesCountBeforeWithoutComment = 1;
    protected abstract function isNextMemberValid(\PHP_CodeSniffer\Files\File $phpcsFile, int $pointer) : bool;
    protected abstract function addError(\PHP_CodeSniffer\Files\File $phpcsFile, int $pointer, int $min, int $max, int $found) : bool;
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param File $phpcsFile
     * @param int $pointer
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $pointer) : int
    {
        $tokens = $phpcsFile->getTokens();
        $classPointer = \SlevomatCodingStandard\Helpers\ClassHelper::getClassPointer($phpcsFile, $pointer);
        $semicolonPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, [\T_SEMICOLON], $pointer + 1);
        \assert($semicolonPointer !== null);
        $firstOnLinePointer = \SlevomatCodingStandard\Helpers\TokenHelper::findFirstTokenOnNextLine($phpcsFile, $semicolonPointer);
        \assert($firstOnLinePointer !== null);
        $nextFunctionPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, [\T_FUNCTION, \T_CONST, \T_VARIABLE, \T_USE], $firstOnLinePointer + 1);
        if ($nextFunctionPointer === null || $tokens[$nextFunctionPointer]['code'] === \T_FUNCTION || $tokens[$nextFunctionPointer]['conditions'] !== $tokens[$pointer]['conditions']) {
            return $nextFunctionPointer ?? $firstOnLinePointer;
        }
        $types = [\T_COMMENT, \T_DOC_COMMENT_OPEN_TAG, \T_CONST, \T_VAR, \T_PUBLIC, \T_PROTECTED, \T_PRIVATE, \T_USE];
        $nextPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, $types, $firstOnLinePointer + 1, $tokens[$classPointer]['scope_closer']);
        if (!$this->isNextMemberValid($phpcsFile, $nextPointer)) {
            return $nextPointer;
        }
        $linesBetween = $tokens[$nextPointer]['line'] - $tokens[$semicolonPointer]['line'] - 1;
        if (\in_array($tokens[$nextPointer]['code'], [\T_DOC_COMMENT_OPEN_TAG, \T_COMMENT], \true)) {
            $minExpectedLines = \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeInteger($this->minLinesCountBeforeWithComment);
            $maxExpectedLines = \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeInteger($this->maxLinesCountBeforeWithComment);
        } else {
            $minExpectedLines = \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeInteger($this->minLinesCountBeforeWithoutComment);
            $maxExpectedLines = \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeInteger($this->maxLinesCountBeforeWithoutComment);
        }
        if ($linesBetween >= $minExpectedLines && $linesBetween <= $maxExpectedLines) {
            return $firstOnLinePointer;
        }
        $fix = $this->addError($phpcsFile, $pointer, $minExpectedLines, $maxExpectedLines, $linesBetween);
        if (!$fix) {
            return $firstOnLinePointer;
        }
        if ($linesBetween > $maxExpectedLines) {
            $lastPointerOnLine = \SlevomatCodingStandard\Helpers\TokenHelper::findLastTokenOnLine($phpcsFile, $semicolonPointer);
            $phpcsFile->fixer->beginChangeset();
            if ($maxExpectedLines > 0) {
                $phpcsFile->fixer->addContent($lastPointerOnLine, \str_repeat($phpcsFile->eolChar, $maxExpectedLines));
            }
            for ($i = $lastPointerOnLine + 1; $i < \SlevomatCodingStandard\Helpers\TokenHelper::findFirstTokenOnLine($phpcsFile, $nextPointer); $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }
            $phpcsFile->fixer->endChangeset();
        } else {
            $phpcsFile->fixer->beginChangeset();
            for ($i = 0; $i < $minExpectedLines; $i++) {
                $phpcsFile->fixer->addNewlineBefore($firstOnLinePointer);
            }
            $phpcsFile->fixer->endChangeset();
        }
        return $firstOnLinePointer;
    }
}
