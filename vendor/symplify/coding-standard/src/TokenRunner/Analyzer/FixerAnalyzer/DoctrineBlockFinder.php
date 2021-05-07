<?php

namespace Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer;

use PhpCsFixer\Doctrine\Annotation\Token;
use PhpCsFixer\Doctrine\Annotation\Tokens;
use PhpCsFixer\Tokenizer\Tokens as PhpTokens;
use Symplify\CodingStandard\Exception\EdgeFindingException;
use Symplify\CodingStandard\TokenRunner\ValueObject\BlockInfo;
use Symplify\CodingStandard\TokenRunner\ValueObject\DocBlockEdgeDefinition;
final class DoctrineBlockFinder
{
    /**
     * @var string[]
     */
    const START_EDGES = ['(', '{'];
    /**
     * @var DocBlockEdgeDefinition[]
     */
    private $docBlockEdgeDefinitions = [];
    /**
     * @var BlockFinder
     */
    private $blockFinder;
    /**
     * @param \Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\BlockFinder $blockFinder
     */
    public function __construct($blockFinder)
    {
        $this->docBlockEdgeDefinitions = [new DocBlockEdgeDefinition(PhpTokens::BLOCK_TYPE_CURLY_BRACE, '{', '}'), new DocBlockEdgeDefinition(PhpTokens::BLOCK_TYPE_PARENTHESIS_BRACE, '(', ')')];
        $this->blockFinder = $blockFinder;
    }
    /**
     * Accepts position to both start and end token, e.g. (, ), {, }
     *
     * @param Tokens<Token> $tokens
     * @param int $position
     * @return \Symplify\CodingStandard\TokenRunner\ValueObject\BlockInfo
     */
    public function findInTokensByEdge($tokens, $position)
    {
        /** @var Token $token */
        $token = $tokens[$position];
        $blockType = $this->getBlockTypeByToken($token);
        if (\in_array($token->getContent(), self::START_EDGES, \true)) {
            $blockStart = $position;
            $blockEnd = $this->findOppositeBlockEdge($tokens, $blockType, $blockStart);
        } else {
            $blockEnd = $position;
            $blockStart = $this->findOppositeBlockEdge($tokens, $blockType, $blockEnd, \false);
        }
        return new BlockInfo($blockStart, $blockEnd);
    }
    /**
     * @param \PhpCsFixer\Doctrine\Annotation\Token $token
     * @return int
     */
    private function getBlockTypeByToken($token)
    {
        return $this->blockFinder->getBlockTypeByContent($token->getContent());
    }
    /**
     * @param Tokens<Token> $tokens
     *
     * @copied from
     * @see \PhpCsFixer\Tokenizer\Tokens::findBlockEnd()
     * @param int $type
     * @param int $searchIndex
     * @param bool $findEnd
     * @return int
     */
    private function findOppositeBlockEdge($tokens, $type, $searchIndex, $findEnd = \true)
    {
        foreach ($this->docBlockEdgeDefinitions as $docBlockEdgeDefinition) {
            if ($docBlockEdgeDefinition->getKind() !== $type) {
                continue;
            }
            return $this->resolveDocBlockEdgeByType($docBlockEdgeDefinition, $searchIndex, $tokens, $findEnd);
        }
        $message = \sprintf('Invalid param type: "%s".', $type);
        throw new EdgeFindingException($message);
    }
    /**
     * @param Tokens<Token> $tokens
     * @param int $startIndex
     * @param int $endIndex
     * @param string $startEdge
     * @param string $endEdge
     * @param int $indexOffset
     * @return int
     */
    private function resolveIndexForBlockLevel($startIndex, $endIndex, $tokens, $startEdge, $endEdge, $indexOffset)
    {
        $blockLevel = 0;
        for ($index = $startIndex; $index !== $endIndex; $index += $indexOffset) {
            /** @var Token $token */
            $token = $tokens[$index];
            if ($token->getContent() === $startEdge) {
                ++$blockLevel;
                continue;
            }
            if ($token->getContent() === $endEdge) {
                --$blockLevel;
                if ($blockLevel === 0) {
                    break;
                }
                continue;
            }
        }
        return $index;
    }
    /**
     * @param Tokens<Token> $tokens
     * @return void
     * @param int $startIndex
     * @param string $startEdge
     * @param bool $findEnd
     */
    private function ensureStartTokenIsNotStartEdge($tokens, $startIndex, $startEdge, $findEnd)
    {
        /** @var Token $startToken */
        $startToken = $tokens[$startIndex];
        if ($startToken->getContent() !== $startEdge) {
            throw new EdgeFindingException(\sprintf('Invalid param $startIndex - not a proper block "%s".', $findEnd ? 'start' : 'end'));
        }
    }
    /**
     * @param Tokens<Token> $tokens
     * @param \Symplify\CodingStandard\TokenRunner\ValueObject\DocBlockEdgeDefinition $docBlockEdgeDefinition
     * @param int $searchIndex
     * @param bool $findEnd
     * @return int
     */
    private function resolveDocBlockEdgeByType($docBlockEdgeDefinition, $searchIndex, $tokens, $findEnd)
    {
        $startChart = $docBlockEdgeDefinition->getStartChar();
        $endChar = $docBlockEdgeDefinition->getEndChar();
        $startIndex = $searchIndex;
        $endIndex = $tokens->count() - 1;
        $indexOffset = 1;
        if (!$findEnd) {
            list($startChart, $endChar) = [$endChar, $startChart];
            $indexOffset = -1;
            $endIndex = 0;
        }
        $this->ensureStartTokenIsNotStartEdge($tokens, $startIndex, $startChart, $findEnd);
        $index = $this->resolveIndexForBlockLevel($startIndex, $endIndex, $tokens, $startChart, $endChar, $indexOffset);
        /** @var Token $currentToken */
        $currentToken = $tokens[$index];
        if ($currentToken->getContent() !== $endChar) {
            $message = \sprintf('Missing block "%s".', $findEnd ? 'end' : 'start');
            throw new EdgeFindingException($message);
        }
        return $index;
    }
}
