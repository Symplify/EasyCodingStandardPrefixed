<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScopera9d6a31d814c\Nette;

/**
 * Static class.
 */
trait StaticClass
{
    /** @throws \Error */
    public final function __construct()
    {
        throw new \Error('Class ' . static::class . ' is static and cannot be instantiated.');
    }
    /**
     * Call to undefined static method.
     * @return void
     * @throws MemberAccessException
     */
    public static function __callStatic(string $name, array $args)
    {
        \_PhpScopera9d6a31d814c\Nette\Utils\ObjectHelpers::strictStaticCall(static::class, $name);
    }
}
