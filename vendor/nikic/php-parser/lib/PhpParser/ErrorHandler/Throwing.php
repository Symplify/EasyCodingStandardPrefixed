<?php

declare (strict_types=1);
namespace _PhpScoper4d05106cc3c0\PhpParser\ErrorHandler;

use _PhpScoper4d05106cc3c0\PhpParser\Error;
use _PhpScoper4d05106cc3c0\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \_PhpScoper4d05106cc3c0\PhpParser\ErrorHandler
{
    public function handleError(\_PhpScoper4d05106cc3c0\PhpParser\Error $error)
    {
        throw $error;
    }
}
