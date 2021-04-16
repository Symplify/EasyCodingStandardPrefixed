<?php

declare (strict_types=1);
namespace _PhpScoper8a8080b03ed6\Jean85\Exception;

interface VersionMissingExceptionInterface extends \Throwable
{
    public static function create(string $packageName) : self;
}
