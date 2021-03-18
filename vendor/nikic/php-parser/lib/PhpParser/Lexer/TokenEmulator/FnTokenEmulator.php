<?php

declare (strict_types=1);
namespace _PhpScoper0ba97041430d\PhpParser\Lexer\TokenEmulator;

use _PhpScoper0ba97041430d\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScoper0ba97041430d\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoper0ba97041430d\PhpParser\Lexer\Emulative::PHP_7_4;
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
