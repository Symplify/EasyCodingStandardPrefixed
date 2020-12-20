<?php

declare (strict_types=1);
namespace _PhpScopera51a90153f58\PhpParser\ErrorHandler;

use _PhpScopera51a90153f58\PhpParser\Error;
use _PhpScopera51a90153f58\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \_PhpScopera51a90153f58\PhpParser\ErrorHandler
{
    public function handleError(\_PhpScopera51a90153f58\PhpParser\Error $error)
    {
        throw $error;
    }
}
