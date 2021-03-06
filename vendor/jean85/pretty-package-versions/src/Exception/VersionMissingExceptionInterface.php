<?php

declare (strict_types=1);
namespace ECSPrefix20210507\Jean85\Exception;

interface VersionMissingExceptionInterface extends \Throwable
{
    public static function create(string $packageName) : self;
}
