<?php

declare (strict_types=1);
namespace _PhpScoper279cf54b77ad\PhpParser\Lexer\TokenEmulator;

use _PhpScoper279cf54b77ad\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScoper279cf54b77ad\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoper279cf54b77ad\PhpParser\Lexer\Emulative::PHP_7_4;
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
