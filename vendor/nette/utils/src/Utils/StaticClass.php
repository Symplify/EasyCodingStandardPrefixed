<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper78af57a363a0\Nette;

/**
 * Static class.
 */
trait StaticClass
{
    /**
     * @throws \Error
     */
    public final function __construct()
    {
        throw new \Error('Class ' . \get_class($this) . ' is static and cannot be instantiated.');
    }
    /**
     * Call to undefined static method.
     * @throws MemberAccessException
     */
    public static function __callStatic(string $name, array $args)
    {
        \_PhpScoper78af57a363a0\Nette\Utils\ObjectHelpers::strictStaticCall(static::class, $name);
    }
}
