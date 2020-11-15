<?php

declare (strict_types=1);
namespace _PhpScoperd9c3b46af121\PhpParser\Lexer\TokenEmulator;

use _PhpScoperd9c3b46af121\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScoperd9c3b46af121\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoperd9c3b46af121\PhpParser\Lexer\Emulative::PHP_7_4;
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
