<?php

declare (strict_types=1);
namespace _PhpScopera37d6fb0b1ab\PhpParser;

interface ErrorHandler
{
    /**
     * Handle an error generated during lexing, parsing or some other operation.
     *
     * @param Error $error The error that needs to be handled
     */
    public function handleError(\_PhpScopera37d6fb0b1ab\PhpParser\Error $error);
}
