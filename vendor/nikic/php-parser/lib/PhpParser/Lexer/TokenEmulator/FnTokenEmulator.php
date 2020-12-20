<?php

declare (strict_types=1);
namespace _PhpScoper57210e33e43a\PhpParser\Lexer\TokenEmulator;

use _PhpScoper57210e33e43a\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScoper57210e33e43a\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoper57210e33e43a\PhpParser\Lexer\Emulative::PHP_7_4;
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
