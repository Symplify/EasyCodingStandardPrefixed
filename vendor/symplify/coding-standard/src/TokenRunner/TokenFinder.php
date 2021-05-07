<?php

namespace Symplify\CodingStandard\TokenRunner;

use ECSPrefix20210507\Nette\Utils\Strings;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class TokenFinder
{
    /**
     * @param int|Token $position
     * @param Tokens<Token> $tokens
     * @return \PhpCsFixer\Tokenizer\Token
     */
    public function getPreviousMeaningfulToken($tokens, $position)
    {
        if (\is_int($position)) {
            return $this->findPreviousTokenByPosition($tokens, $position);
        }
        return $this->findPreviousTokenByToken($tokens, $position);
    }
    /**
     * @param mixed[] $tokens
     * @return mixed[]|string|null
     * @param int $position
     */
    public function getNextMeaninfulToken(array $tokens, $position)
    {
        $tokens = $this->getNextMeaninfulTokens($tokens, $position, 1);
        return isset($tokens[0]) ? $tokens[0] : null;
    }
    /**
     * @param mixed[] $tokens
     * @return mixed[]
     * @param int $position
     * @param int $count
     */
    public function getNextMeaninfulTokens(array $tokens, $position, $count)
    {
        $foundTokens = [];
        $tokensCount = \count($tokens);
        for ($i = $position; $i < $tokensCount; ++$i) {
            $token = $tokens[$i];
            if ($token[0] === \T_WHITESPACE) {
                continue;
            }
            if (\count($foundTokens) === $count) {
                break;
            }
            $foundTokens[] = $token;
        }
        return $foundTokens;
    }
    /**
     * @param mixed[] $rawTokens
     * @return mixed[]|string
     * @param int $position
     */
    public function getSameRowLastToken(array $rawTokens, $position)
    {
        $lastToken = null;
        $rawTokensCount = \count($rawTokens);
        for ($i = $position; $i < $rawTokensCount; ++$i) {
            $token = $rawTokens[$i];
            if (\is_array($token) && Strings::contains($token[1], \PHP_EOL)) {
                break;
            }
            $lastToken = $token;
        }
        return $lastToken;
    }
    /**
     * @param Tokens<Token> $tokens
     * @param int $position
     * @return \PhpCsFixer\Tokenizer\Token
     */
    private function findPreviousTokenByPosition($tokens, $position)
    {
        $previousPosition = $position - 1;
        if (!isset($tokens[$previousPosition])) {
            throw new ShouldNotHappenException();
        }
        return $tokens[$previousPosition];
    }
    /**
     * @param Tokens<Token> $tokens
     * @param \PhpCsFixer\Tokenizer\Token $positionToken
     * @return \PhpCsFixer\Tokenizer\Token
     */
    private function findPreviousTokenByToken($tokens, $positionToken)
    {
        $position = $this->resolvePositionByToken($tokens, $positionToken);
        return $this->findPreviousTokenByPosition($tokens, $position - 1);
    }
    /**
     * @param Tokens<Token> $tokens
     * @param \PhpCsFixer\Tokenizer\Token $positionToken
     * @return int
     */
    private function resolvePositionByToken($tokens, $positionToken)
    {
        foreach ($tokens as $position => $token) {
            if ($token === $positionToken) {
                return $position;
            }
        }
        throw new ShouldNotHappenException();
    }
}
