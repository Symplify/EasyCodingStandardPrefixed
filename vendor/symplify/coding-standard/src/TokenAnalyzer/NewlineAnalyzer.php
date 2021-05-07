<?php

namespace Symplify\CodingStandard\TokenAnalyzer;

use ECSPrefix20210507\Nette\Utils\Strings;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
final class NewlineAnalyzer
{
    /**
     * @param Tokens<Token> $tokens
     * @param int $i
     * @return bool
     */
    public function doesContentBeforeBracketRequireNewline($tokens, $i)
    {
        $previousMeaningfulTokenPosition = $tokens->getPrevNonWhitespace($i);
        if ($previousMeaningfulTokenPosition === null) {
            return \false;
        }
        $previousToken = $tokens[$previousMeaningfulTokenPosition];
        if (!$previousToken->isGivenKind(\T_STRING)) {
            return \false;
        }
        $previousPreviousMeaningfulTokenPosition = $tokens->getPrevNonWhitespace($previousMeaningfulTokenPosition);
        if ($previousPreviousMeaningfulTokenPosition === null) {
            return \false;
        }
        $previousPreviousToken = $tokens[$previousPreviousMeaningfulTokenPosition];
        if ($previousPreviousToken->getContent() === '{') {
            return \true;
        }
        // is a function
        return $previousPreviousToken->isGivenKind([\T_RETURN, \T_DOUBLE_COLON, T_OPEN_CURLY_BRACKET]);
    }
    /**
     * @param \PhpCsFixer\Tokenizer\Token $currentToken
     * @return bool
     */
    public function isNewlineToken($currentToken)
    {
        if (!$currentToken->isWhitespace()) {
            return \false;
        }
        return Strings::contains($currentToken->getContent(), "\n");
    }
}
