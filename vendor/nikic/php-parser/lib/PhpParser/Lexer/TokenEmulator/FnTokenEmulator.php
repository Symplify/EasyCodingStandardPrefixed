<?php

declare (strict_types=1);
namespace _PhpScoper167729fa1dde\PhpParser\Lexer\TokenEmulator;

use _PhpScoper167729fa1dde\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScoper167729fa1dde\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoper167729fa1dde\PhpParser\Lexer\Emulative::PHP_7_4;
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
