<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\DocBlock;

use _PhpScoperd51690aa3091\Nette\Utils\Strings;
use PhpCsFixer\Tokenizer\Token;
final class UselessDocBlockCleaner
{
    /**
     * @var string[]
     */
    private const CLEANING_REGEXES = [self::TODO_COMMENT_BY_PHPSTORM_REGEX, self::TODO_IMPLEMENT_METHOD_COMMENT_BY_PHPSTORM_REGEX, self::COMMENT_CLASS_REGEX, self::COMMENT_CONSTRUCTOR_CLASS_REGEX, self::COMMENT_METHOD_CLASS_REGEX];
    /**
     * @see https://regex101.com/r/5fQJkz/2
     * @var string
     */
    private const TODO_IMPLEMENT_METHOD_COMMENT_BY_PHPSTORM_REGEX = '#\\/\\/ TODO: Implement .*\\(\\) method.$#';
    /**
     * @see https://regex101.com/r/zayQpv/1
     * @var string
     */
    private const TODO_COMMENT_BY_PHPSTORM_REGEX = '#\\/\\/ TODO: Change the autogenerated stub$#';
    /**
     * @see https://regex101.com/r/QeAiRV/1
     * @var string
     */
    private const SPACE_STAR_SLASH_REGEX = '#[\\s\\*\\/]#';
    /**
     * @see https://regex101.com/r/S1wAAh/2
     * @var string
     */
    private const COMMENT_METHOD_CLASS_REGEX = '#^\\s{0,}(\\/\\*{2}\\s+?)?(\\*|\\/\\/)\\s+([Gg]et|[Ss]et)\\s+[^\\s]*\\.?(\\s+\\*\\/)?$#';
    /**
     * @see https://regex101.com/r/eBux3I/1
     * @var string
     */
    private const COMMENT_ANY_METHOD_CLASS_REGEX = '#^\\s{0,}(\\/\\*{2}\\s+?)?(\\*|\\/\\/)\\s+(?<obvious_method_comment>([Gg]et|[Ss]et)\\s+(.*))(\\s+\\*\\/)?$#';
    /**
     * @see https://regex101.com/r/RzTdFH/4
     * @var string
     */
    private const COMMENT_CLASS_REGEX = '#(\\/\\*{2}\\s+?)?(\\*|\\/\\/)\\s+[cC]lass\\s+[^\\s]*(\\s+\\*\\/)?$#';
    /**
     * @see https://regex101.com/r/bzbxXz/2
     * @var string
     */
    private const COMMENT_CONSTRUCTOR_CLASS_REGEX = '#^\\s{0,}(\\/\\*{2}\\s+?)?(\\*|\\/\\/)\\s+[^\\s]*\\s+[Cc]onstructor\\.?(\\s+\\*\\/)?$#';
    public function clearDocTokenContent(array $tokens, int $position, string $docContent) : string
    {
        foreach (self::CLEANING_REGEXES as $cleaningRegex) {
            $docContent = Strings::replace($docContent, $cleaningRegex, '');
        }
        return $this->cleanClassMethodCommentMimicMethodName($tokens, $position, $docContent);
    }
    /**
     * @param Token[] $reversedTokens
     */
    private function cleanClassMethodCommentMimicMethodName(array $reversedTokens, int $index, string $docContent) : string
    {
        $matchMethodClass = Strings::match($docContent, self::COMMENT_METHOD_CLASS_REGEX);
        if ($matchMethodClass) {
            return $docContent;
        }
        if (!$this->isNextFunction($reversedTokens, $index)) {
            return $docContent;
        }
        $matchAnyMethodClass = Strings::match($docContent, self::COMMENT_ANY_METHOD_CLASS_REGEX);
        if (!$matchAnyMethodClass) {
            return $docContent;
        }
        $obviousMethodComment = $matchAnyMethodClass['obvious_method_comment'];
        $obviousMethodComment = $this->removeSpaces($obviousMethodComment);
        $methodNameContent = $reversedTokens[$index + 6]->getContent();
        if (\strtolower($obviousMethodComment) !== \strtolower($methodNameContent)) {
            return $docContent;
        }
        return Strings::replace($docContent, self::COMMENT_ANY_METHOD_CLASS_REGEX, '');
    }
    private function isNextFunction(array $reversedTokens, int $index) : bool
    {
        if (!isset($reversedTokens[$index + 4])) {
            return \false;
        }
        return $reversedTokens[$index + 4]->getContent() === 'function';
    }
    private function removeSpaces(string $content) : string
    {
        return Strings::replace($content, self::SPACE_STAR_SLASH_REGEX, '');
    }
}
