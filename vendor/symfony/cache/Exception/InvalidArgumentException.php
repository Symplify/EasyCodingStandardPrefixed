<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopera8f555a7493c\Symfony\Component\Cache\Exception;

use _PhpScopera8f555a7493c\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use _PhpScopera8f555a7493c\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\_PhpScopera8f555a7493c\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScopera8f555a7493c\Psr\Cache\InvalidArgumentException, \_PhpScopera8f555a7493c\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScopera8f555a7493c\Psr\Cache\InvalidArgumentException
    {
    }
}
