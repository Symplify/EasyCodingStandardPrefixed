<?php

namespace Symplify\CodingStandard\TokenRunner\Transformer\FixerTransformer;

use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\CallAnalyzer;
use Symplify\CodingStandard\TokenRunner\Exception\TokenNotFoundException;
final class LineLengthOpenerTransformer
{
    /**
     * @var CallAnalyzer
     */
    private $callAnalyzer;
    /**
     * @param \Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\CallAnalyzer $callAnalyzer
     */
    public function __construct($callAnalyzer)
    {
        $this->callAnalyzer = $callAnalyzer;
    }
    /**
     * @param Tokens<Token> $tokens
     * @return void
     * @param int $blockStartIndex
     * @param string $newlineIndentWhitespace
     */
    public function insertNewlineAfterOpeningIfNeeded($tokens, $blockStartIndex, $newlineIndentWhitespace)
    {
        if (!isset($tokens[$blockStartIndex + 1])) {
            throw new TokenNotFoundException($blockStartIndex + 1);
        }
        /** @var Token $nextToken */
        $nextToken = $tokens[$blockStartIndex + 1];
        if ($nextToken->isGivenKind(\T_WHITESPACE)) {
            $tokens->ensureWhitespaceAtIndex($blockStartIndex + 1, 0, $newlineIndentWhitespace);
            return;
        }
        // special case, if the function is followed by array - method([...])
        if ($nextToken->isGivenKind([\T_ARRAY, CT::T_ARRAY_SQUARE_BRACE_OPEN]) && !$this->callAnalyzer->isMethodCall($tokens, $blockStartIndex)) {
            $tokens->ensureWhitespaceAtIndex($blockStartIndex + 1, 1, $newlineIndentWhitespace);
            return;
        }
        $tokens->ensureWhitespaceAtIndex($blockStartIndex, 1, $newlineIndentWhitespace);
    }
}
