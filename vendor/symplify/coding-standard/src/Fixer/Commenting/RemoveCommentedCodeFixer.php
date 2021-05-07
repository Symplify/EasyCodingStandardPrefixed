<?php

namespace Symplify\CodingStandard\Fixer\Commenting;

use ECSPrefix20210507\Nette\Utils\Strings;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Symplify\CodingStandard\DocBlock\Decommenter;
use Symplify\CodingStandard\Fixer\AbstractSymplifyFixer;
use Symplify\CodingStandard\Php\PhpContentAnalyzer;
use Symplify\CodingStandard\Tokens\CommentedContentResolver;
use Symplify\CodingStandard\ValueObject\StartAndEnd;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://softwareengineering.stackexchange.com/a/394288/148956
 *
 * @see \Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveCommentedCodeFixer\RemoveCommentedCodeFixerTest
 */
final class RemoveCommentedCodeFixer extends AbstractSymplifyFixer implements DocumentedRuleInterface
{
    /**
     * @var string
     */
    const ERROR_MESSAGE = 'Remove commented code like "// $one = 1000;"';
    /**
     * @var CommentedContentResolver
     */
    private $commentedContentResolver;
    /**
     * @var PhpContentAnalyzer
     */
    private $phpContentAnalyzer;
    /**
     * @var Decommenter
     */
    private $decommenter;
    /**
     * @param \Symplify\CodingStandard\Tokens\CommentedContentResolver $commentedContentResolver
     * @param \Symplify\CodingStandard\Php\PhpContentAnalyzer $phpContentAnalyzer
     * @param \Symplify\CodingStandard\DocBlock\Decommenter $decommenter
     */
    public function __construct($commentedContentResolver, $phpContentAnalyzer, $decommenter)
    {
        $this->commentedContentResolver = $commentedContentResolver;
        $this->phpContentAnalyzer = $phpContentAnalyzer;
        $this->decommenter = $decommenter;
    }
    /**
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new FixerDefinition(self::ERROR_MESSAGE, []);
    }
    /**
     * @param Tokens<Token> $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isTokenKindFound(\T_COMMENT);
    }
    /**
     * @param Tokens<Token> $tokens
     * @return void
     * @param \SplFileInfo $file
     */
    public function fix($file, $tokens)
    {
        $contentWithPositions = [];
        for ($i = 0; $i < $tokens->count(); ++$i) {
            $token = $tokens[$i];
            if (!$token->isGivenKind(\T_COMMENT)) {
                continue;
            }
            if (!Strings::startsWith($token->getContent(), '//')) {
                continue;
            }
            $startAndEnd = $this->commentedContentResolver->resolve($tokens, $i);
            // new position to jump to
            $i = $startAndEnd->getEnd() + 1;
            $commentedContent = $tokens->generatePartialCode($startAndEnd->getStart(), $startAndEnd->getEnd());
            $possiblePhpContent = $this->decommenter->decoment($commentedContent);
            if (!$this->phpContentAnalyzer->isPhpContent($possiblePhpContent)) {
                continue;
            }
            // clear PHP commented content
            $contentWithPositions[] = $startAndEnd;
        }
        /** @var StartAndEnd[] $contentWithPositions */
        $contentWithPositions = \array_reverse($contentWithPositions);
        foreach ($contentWithPositions as $startAndEnd) {
            $realStart = $this->resolveRealStart($startAndEnd, $tokens);
            $tokens->clearRange($realStart, $startAndEnd->getEnd());
        }
    }
    /**
     * @return \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
     */
    public function getRuleDefinition()
    {
        return new RuleDefinition(self::ERROR_MESSAGE, [new CodeSample(<<<'CODE_SAMPLE'
// $one = 1;
// $two = 2;
// $three = 3;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
CODE_SAMPLE
)]);
    }
    /**
     * Remove the indent space ahead of comments
     *
     * @param Tokens<Token> $tokens
     * @param \Symplify\CodingStandard\ValueObject\StartAndEnd $startAndEnd
     * @return int
     */
    private function resolveRealStart($startAndEnd, $tokens)
    {
        $preStartPosition = $startAndEnd->getStart() - 1;
        /** @var Token $preStartToken */
        $preStartToken = $tokens[$preStartPosition];
        $realStart = $startAndEnd->getStart();
        if ($preStartToken->getContent() === \PHP_EOL) {
            return $realStart - 1;
        }
        if (Strings::endsWith($preStartToken->getContent(), '    ')) {
            return $realStart - 1;
        }
        return $realStart;
    }
}
