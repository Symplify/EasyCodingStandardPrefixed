<?php

declare (strict_types=1);
namespace _PhpScoper57272265e1c9\PhpParser\Lexer\TokenEmulator;

use _PhpScoper57272265e1c9\PhpParser\Lexer\Emulative;
final class MatchTokenEmulator extends \_PhpScoper57272265e1c9\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoper57272265e1c9\PhpParser\Lexer\Emulative::PHP_8_0;
    }
    public function getKeywordString() : string
    {
        return 'match';
    }
    public function getKeywordToken() : int
    {
        return \T_MATCH;
    }
}
