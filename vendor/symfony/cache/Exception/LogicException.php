<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbcc0395698f8\Symfony\Component\Cache\Exception;

use _PhpScoperbcc0395698f8\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoperbcc0395698f8\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperbcc0395698f8\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \_PhpScoperbcc0395698f8\Psr\Cache\CacheException, \_PhpScoperbcc0395698f8\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \_PhpScoperbcc0395698f8\Psr\Cache\CacheException
    {
    }
}
