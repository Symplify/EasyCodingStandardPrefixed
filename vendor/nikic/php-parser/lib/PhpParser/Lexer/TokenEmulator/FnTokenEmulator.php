<?php

declare (strict_types=1);
namespace _PhpScoperad68e34a80c5\PhpParser\Lexer\TokenEmulator;

use _PhpScoperad68e34a80c5\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScoperad68e34a80c5\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoperad68e34a80c5\PhpParser\Lexer\Emulative::PHP_7_4;
    }
    public function getKeywordString() : string
    {
        return 'fn';
    }
    public function getKeywordToken() : int
    {
        return \T_FN;
    }
}
