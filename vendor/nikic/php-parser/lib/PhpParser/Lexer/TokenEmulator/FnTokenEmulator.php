<?php

declare (strict_types=1);
namespace _PhpScoper58a0a169dcfb\PhpParser\Lexer\TokenEmulator;

use _PhpScoper58a0a169dcfb\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScoper58a0a169dcfb\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoper58a0a169dcfb\PhpParser\Lexer\Emulative::PHP_7_4;
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
