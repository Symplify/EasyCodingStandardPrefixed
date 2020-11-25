<?php

declare (strict_types=1);
namespace _PhpScoper13133e188f67\PhpParser;

interface ErrorHandler
{
    /**
     * Handle an error generated during lexing, parsing or some other operation.
     *
     * @param Error $error The error that needs to be handled
     */
    public function handleError(\_PhpScoper13133e188f67\PhpParser\Error $error);
}
