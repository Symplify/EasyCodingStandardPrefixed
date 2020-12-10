<?php

declare (strict_types=1);
namespace _PhpScoper2731c1906fe4\PhpParser\ErrorHandler;

use _PhpScoper2731c1906fe4\PhpParser\Error;
use _PhpScoper2731c1906fe4\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \_PhpScoper2731c1906fe4\PhpParser\ErrorHandler
{
    public function handleError(\_PhpScoper2731c1906fe4\PhpParser\Error $error)
    {
        throw $error;
    }
}
