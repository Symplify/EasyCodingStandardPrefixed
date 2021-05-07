<?php

namespace Symplify\CodingStandard\Tokens;

use ECSPrefix20210507\Nette\Utils\Strings;
/**
 * Heavily inspired by
 *
 * @see https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Squiz/Sniffs/PHP/CommentedOutCodeSniff.php
 */
final class CommentedLineTrimmer
{
    /**
     * @var string[]
     */
    const OPENING_LINE = ['//', '#'];
    /**
     * @param string $tokenContent
     * @return string
     */
    public function trim($tokenContent)
    {
        foreach (self::OPENING_LINE as $openingLine) {
            if (!Strings::startsWith($tokenContent, $openingLine)) {
                continue;
            }
            return \substr($tokenContent, \strlen($openingLine));
        }
        return $tokenContent;
    }
}
