<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\TokenHelper;
use const _PhpScoperad68e34a80c5\T_ANON_CLASS;
use const _PhpScoperad68e34a80c5\T_CLOSE_PARENTHESIS;
use const _PhpScoperad68e34a80c5\T_CLOSE_SHORT_ARRAY;
use const _PhpScoperad68e34a80c5\T_CLOSE_SQUARE_BRACKET;
use const T_COALESCE;
use const _PhpScoperad68e34a80c5\T_COMMA;
use const T_DOUBLE_ARROW;
use const _PhpScoperad68e34a80c5\T_INLINE_ELSE;
use const _PhpScoperad68e34a80c5\T_INLINE_THEN;
use const T_NEW;
use const _PhpScoperad68e34a80c5\T_OPEN_PARENTHESIS;
use const _PhpScoperad68e34a80c5\T_SEMICOLON;
use const T_WHITESPACE;
class NewWithoutParenthesesSniff implements \PHP_CodeSniffer\Sniffs\Sniff
{
    public const CODE_USELESS_PARENTHESES = 'UselessParentheses';
    /**
     * @return array<int, (int|string)>
     */
    public function register() : array
    {
        return [\T_NEW];
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param File $phpcsFile
     * @param int $newPointer
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $newPointer) : void
    {
        $tokens = $phpcsFile->getTokens();
        /** @var int $nextPointer */
        $nextPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $newPointer + 1);
        if ($tokens[$nextPointer]['code'] === \T_ANON_CLASS) {
            return;
        }
        $parenthesisOpenerPointer = $nextPointer + 1;
        do {
            /** @var int $parenthesisOpenerPointer */
            $parenthesisOpenerPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, [\T_OPEN_PARENTHESIS, \T_SEMICOLON, \T_COMMA, \T_INLINE_THEN, \T_INLINE_ELSE, \T_COALESCE, \T_CLOSE_SHORT_ARRAY, \T_CLOSE_SQUARE_BRACKET, \T_CLOSE_PARENTHESIS, \T_DOUBLE_ARROW], $parenthesisOpenerPointer);
            if ($tokens[$parenthesisOpenerPointer]['code'] !== \T_CLOSE_SQUARE_BRACKET || $tokens[$parenthesisOpenerPointer]['bracket_opener'] <= $newPointer) {
                break;
            }
            $parenthesisOpenerPointer++;
        } while (\true);
        if ($tokens[$parenthesisOpenerPointer]['code'] !== \T_OPEN_PARENTHESIS) {
            return;
        }
        $nextPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextExcluding($phpcsFile, \T_WHITESPACE, $parenthesisOpenerPointer + 1);
        if ($nextPointer !== $tokens[$parenthesisOpenerPointer]['parenthesis_closer']) {
            return;
        }
        $fix = $phpcsFile->addFixableError('Useless parentheses in "new".', $newPointer, self::CODE_USELESS_PARENTHESES);
        if (!$fix) {
            return;
        }
        $phpcsFile->fixer->beginChangeset();
        for ($i = $parenthesisOpenerPointer; $i <= $tokens[$parenthesisOpenerPointer]['parenthesis_closer']; $i++) {
            $phpcsFile->fixer->replaceToken($i, '');
        }
        $phpcsFile->fixer->endChangeset();
    }
}
