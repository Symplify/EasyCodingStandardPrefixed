<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Fixer\Annotation;

use _PhpScoperc7096eb2567d\Doctrine\Common\Annotations\DocLexer;
use _PhpScoperc7096eb2567d\Nette\Utils\Strings;
use PhpCsFixer\AbstractDoctrineAnnotationFixer;
use PhpCsFixer\Doctrine\Annotation\Token;
use PhpCsFixer\Doctrine\Annotation\Tokens;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\DoctrineBlockFinder;
use Symplify\CodingStandard\TokenRunner\ValueObject\BlockInfo;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Symplify\CodingStandard\Tests\Fixer\Annotation\DoctrineAnnotationNewlineInNestedAnnotationFixer\DoctrineAnnotationNewlineInNestedAnnotationFixerTest
 */
final class DoctrineAnnotationNewlineInNestedAnnotationFixer extends \PhpCsFixer\AbstractDoctrineAnnotationFixer implements \Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Nested object annotations should start on a standalone line';
    /**
     * @var DoctrineBlockFinder
     */
    private $doctrineBlockFinder;
    /**
     * @var BlockInfo|null
     */
    private $currentBlockInfo;
    public function __construct(\Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\DoctrineBlockFinder $doctrineBlockFinder)
    {
        $this->doctrineBlockFinder = $doctrineBlockFinder;
        parent::__construct();
    }
    public function getPriority() : int
    {
        // must run before \PhpCsFixer\Fixer\DoctrineAnnotation\DoctrineAnnotationIndentationFixer
        return 100;
    }
    public function getDefinition() : \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition(self::ERROR_MESSAGE, []);
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition(self::ERROR_MESSAGE, [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user", indexes={@ORM\Index(name="user_id", columns={"another_id"})})
 */
class SomeEntity
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user", indexes={
 * @ORM\Index(name="user_id", columns={"another_id"})
 * })
 */
class SomeEntity
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @note indent is covered by
     * @see \PhpCsFixer\Fixer\DoctrineAnnotation\DoctrineAnnotationIndentationFixer
     *
     * @param iterable<Token>&Tokens $tokens
     */
    protected function fixAnnotations(\PhpCsFixer\Doctrine\Annotation\Tokens $tokens) : void
    {
        $this->currentBlockInfo = null;
        $tokenCount = $tokens->count();
        // what about foreach?
        for ($index = 0; $index < $tokenCount; ++$index) {
            /** @var Token $currentToken */
            $currentToken = $tokens[$index];
            if (!$currentToken->isType(\_PhpScoperc7096eb2567d\Doctrine\Common\Annotations\DocLexer::T_AT)) {
                continue;
            }
            $previousTokenPosition = $index - 1;
            $previousToken = $tokens[$previousTokenPosition] ?? null;
            if ($previousToken === null) {
                continue;
            }
            if ($this->shouldSkip($index, $tokens, $previousToken)) {
                continue;
            }
            $tokens->insertAt($index, new \PhpCsFixer\Doctrine\Annotation\Token(\_PhpScoperc7096eb2567d\Doctrine\Common\Annotations\DocLexer::T_NONE, ' * '));
            $tokens->insertAt($index, new \PhpCsFixer\Doctrine\Annotation\Token(\_PhpScoperc7096eb2567d\Doctrine\Common\Annotations\DocLexer::T_NONE, "\n"));
            $tNone = $previousToken->isType(\_PhpScoperc7096eb2567d\Doctrine\Common\Annotations\DocLexer::T_NONE);
            // remove redundant space
            if ($tNone) {
                $tokens->offsetUnset($previousTokenPosition);
            }
            $this->processEndBracket($index, $tokens, $previousTokenPosition);
        }
    }
    private function isDocOpener(\PhpCsFixer\Doctrine\Annotation\Token $token) : bool
    {
        if ($token->isType(\_PhpScoperc7096eb2567d\Doctrine\Common\Annotations\DocLexer::T_NONE)) {
            return \_PhpScoperc7096eb2567d\Nette\Utils\Strings::contains($token->getContent(), '*');
        }
        return \false;
    }
    /**
     * @param Tokens<Token> $tokens
     */
    private function processEndBracket(int $index, \PhpCsFixer\Doctrine\Annotation\Tokens $tokens, int $previousTokenPosition) : void
    {
        /** @var Token $previousToken */
        $previousToken = $tokens->offsetGet($previousTokenPosition);
        // already a space → skip
        if ($previousToken->isType(\_PhpScoperc7096eb2567d\Doctrine\Common\Annotations\DocLexer::T_NONE)) {
            return;
        }
        // reset
        if ($this->currentBlockInfo !== null && !$this->currentBlockInfo->contains($index)) {
            $this->currentBlockInfo = null;
            return;
        }
        if ($this->currentBlockInfo === null) {
            $this->currentBlockInfo = $this->doctrineBlockFinder->findInTokensByEdge($tokens, $previousTokenPosition);
        }
        if ($this->currentBlockInfo !== null) {
            $tokens->insertAt($this->currentBlockInfo->getEnd(), new \PhpCsFixer\Doctrine\Annotation\Token(\_PhpScoperc7096eb2567d\Doctrine\Common\Annotations\DocLexer::T_NONE, ' * '));
            $tokens->insertAt($this->currentBlockInfo->getEnd(), new \PhpCsFixer\Doctrine\Annotation\Token(\_PhpScoperc7096eb2567d\Doctrine\Common\Annotations\DocLexer::T_NONE, "\n"));
        }
    }
    /**
     * @param Tokens<Token> $tokens
     */
    private function shouldSkip(int $index, \PhpCsFixer\Doctrine\Annotation\Tokens $tokens, \PhpCsFixer\Doctrine\Annotation\Token $previousToken) : bool
    {
        // docblock opener → skip it
        if ($this->isDocOpener($previousToken)) {
            return \true;
        }
        $nextTokenPosition = $index + 1;
        $nextToken = $tokens[$nextTokenPosition] ?? null;
        if (!$nextToken instanceof \PhpCsFixer\Doctrine\Annotation\Token) {
            return \true;
        }
        if (!\_PhpScoperc7096eb2567d\Nette\Utils\Strings::startsWith($nextToken->getContent(), 'ORM')) {
            return \true;
        }
        // not an entity annotation, just some comment
        return $nextToken->getContent() === 'ORM';
    }
}
