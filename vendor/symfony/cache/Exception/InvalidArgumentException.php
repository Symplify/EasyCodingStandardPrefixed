<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopere66f4b626446\Symfony\Component\Cache\Exception;

use _PhpScopere66f4b626446\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use _PhpScopere66f4b626446\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\_PhpScopere66f4b626446\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScopere66f4b626446\Psr\Cache\InvalidArgumentException, \_PhpScopere66f4b626446\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScopere66f4b626446\Psr\Cache\InvalidArgumentException
    {
    }
}
