<?php

declare (strict_types=1);
namespace _PhpScoperad4b7e2c09d8\PhpParser;

interface Parser
{
    /**
     * Parses PHP code into a node tree.
     *
     * @param string $code The source code to parse
     * @param ErrorHandler|null $errorHandler Error handler to use for lexer/parser errors, defaults
     *                                        to ErrorHandler\Throwing.
     *
     * @return Node\Stmt[]|null Array of statements (or null non-throwing error handler is used and
     *                          the parser was unable to recover from an error).
     */
    public function parse(string $code, \_PhpScoperad4b7e2c09d8\PhpParser\ErrorHandler $errorHandler = null);
}
