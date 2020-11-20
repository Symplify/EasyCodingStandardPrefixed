<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;
use SlevomatCodingStandard\Helpers\ConditionHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use function array_key_exists;
use function in_array;
use function sprintf;
use function strtolower;
use const T_ELSE;
use const _PhpScoper5a9febfbbe05\T_FALSE;
use const T_IF;
use const T_RETURN;
use const _PhpScoper5a9febfbbe05\T_SEMICOLON;
use const _PhpScoper5a9febfbbe05\T_TRUE;
class UselessIfConditionWithReturnSniff implements \PHP_CodeSniffer\Sniffs\Sniff
{
    public const CODE_USELESS_IF_CONDITION = 'UselessIfCondition';
    /** @var bool */
    public $assumeAllConditionExpressionsAreAlreadyBoolean = \false;
    /**
     * @return array<int, (int|string)>
     */
    public function register() : array
    {
        return [\T_IF];
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param File $phpcsFile
     * @param int $ifPointer
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $ifPointer) : void
    {
        $tokens = $phpcsFile->getTokens();
        if (!\array_key_exists('scope_closer', $tokens[$ifPointer])) {
            // If without curly braces is not supported.
            return;
        }
        $ifBooleanPointer = $this->findBooleanAfterReturnInScope($phpcsFile, $tokens[$ifPointer]['scope_opener']);
        if ($ifBooleanPointer === null) {
            return;
        }
        $newCondition = static function () use($phpcsFile, $tokens, $ifBooleanPointer, $ifPointer) : string {
            return \strtolower($tokens[$ifBooleanPointer]['content']) === 'true' ? \SlevomatCodingStandard\Helpers\TokenHelper::getContent($phpcsFile, $tokens[$ifPointer]['parenthesis_opener'] + 1, $tokens[$ifPointer]['parenthesis_closer'] - 1) : \SlevomatCodingStandard\Helpers\ConditionHelper::getNegativeCondition($phpcsFile, $tokens[$ifPointer]['parenthesis_opener'] + 1, $tokens[$ifPointer]['parenthesis_closer'] - 1);
        };
        $elsePointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $tokens[$ifPointer]['scope_closer'] + 1);
        $errorParameters = ['Useless condition.', $ifPointer, self::CODE_USELESS_IF_CONDITION];
        if ($elsePointer !== null && $tokens[$elsePointer]['code'] === \T_ELSE) {
            if (!\array_key_exists('scope_closer', $tokens[$elsePointer])) {
                // Else without curly braces is not supported.
                return;
            }
            $elseBooleanPointer = $this->findBooleanAfterReturnInScope($phpcsFile, $tokens[$elsePointer]['scope_opener']);
            if ($elseBooleanPointer === null) {
                return;
            }
            if (!$this->isFixable($phpcsFile, $ifPointer, $tokens[$elsePointer]['scope_closer'])) {
                $phpcsFile->addError(...$errorParameters);
                return;
            }
            $fix = $phpcsFile->addFixableError(...$errorParameters);
            if (!$fix) {
                return;
            }
            $phpcsFile->fixer->beginChangeset();
            $phpcsFile->fixer->replaceToken($ifPointer, \sprintf('return %s;', $newCondition()));
            for ($i = $ifPointer + 1; $i <= $tokens[$elsePointer]['scope_closer']; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }
            $phpcsFile->fixer->endChangeset();
        } else {
            /** @var int $returnPointer */
            $returnPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $tokens[$ifPointer]['scope_closer'] + 1);
            if ($tokens[$returnPointer]['code'] !== \T_RETURN) {
                return;
            }
            $semicolonPointer = $this->findSemicolonAfterReturnWithBoolean($phpcsFile, $returnPointer);
            if ($semicolonPointer === null) {
                return;
            }
            if (!$this->isFixable($phpcsFile, $ifPointer, $semicolonPointer)) {
                $phpcsFile->addError(...$errorParameters);
                return;
            }
            $fix = $phpcsFile->addFixableError(...$errorParameters);
            if (!$fix) {
                return;
            }
            $phpcsFile->fixer->beginChangeset();
            $phpcsFile->fixer->replaceToken($ifPointer, \sprintf('return %s;', $newCondition()));
            for ($i = $ifPointer + 1; $i <= $semicolonPointer; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }
            $phpcsFile->fixer->endChangeset();
        }
    }
    private function isFixable(\PHP_CodeSniffer\Files\File $phpcsFile, int $ifPointer, int $endPointer) : bool
    {
        $tokens = $phpcsFile->getTokens();
        if (\SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \PHP_CodeSniffer\Util\Tokens::$commentTokens, $ifPointer + 1, $endPointer) !== null) {
            return \false;
        }
        if ($this->assumeAllConditionExpressionsAreAlreadyBoolean) {
            return \true;
        }
        return \SlevomatCodingStandard\Helpers\ConditionHelper::conditionReturnsBoolean($phpcsFile, $tokens[$ifPointer]['parenthesis_opener'] + 1, $tokens[$ifPointer]['parenthesis_closer'] - 1);
    }
    private function findBooleanAfterReturnInScope(\PHP_CodeSniffer\Files\File $phpcsFile, int $scopeOpenerPointer) : ?int
    {
        $tokens = $phpcsFile->getTokens();
        /** @var int $returnPointer */
        $returnPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $scopeOpenerPointer + 1);
        if ($tokens[$returnPointer]['code'] !== \T_RETURN) {
            return null;
        }
        $booleanPointer = $this->findBooleanAfterReturn($phpcsFile, $returnPointer);
        if ($booleanPointer === null) {
            return null;
        }
        $semicolonPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $booleanPointer + 1);
        if ($tokens[$semicolonPointer]['code'] !== \T_SEMICOLON) {
            return null;
        }
        return $booleanPointer;
    }
    private function findBooleanAfterReturn(\PHP_CodeSniffer\Files\File $phpcsFile, int $returnPointer) : ?int
    {
        $tokens = $phpcsFile->getTokens();
        $booleanPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $returnPointer + 1);
        if (\in_array($tokens[$booleanPointer]['code'], [\T_TRUE, \T_FALSE], \true)) {
            return $booleanPointer;
        }
        return null;
    }
    private function findSemicolonAfterReturnWithBoolean(\PHP_CodeSniffer\Files\File $phpcsFile, int $returnPointer) : ?int
    {
        $tokens = $phpcsFile->getTokens();
        $booleanPointer = $this->findBooleanAfterReturn($phpcsFile, $returnPointer);
        if ($booleanPointer === null) {
            return null;
        }
        $semicolonPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $booleanPointer + 1);
        if ($tokens[$semicolonPointer]['code'] !== \T_SEMICOLON) {
            return null;
        }
        return $semicolonPointer;
    }
}
