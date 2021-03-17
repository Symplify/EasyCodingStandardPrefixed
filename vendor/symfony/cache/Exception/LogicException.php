<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper246d3630afdd\Symfony\Component\Cache\Exception;

use _PhpScoper246d3630afdd\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoper246d3630afdd\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoper246d3630afdd\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \_PhpScoper246d3630afdd\Psr\Cache\CacheException, \_PhpScoper246d3630afdd\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \_PhpScoper246d3630afdd\Psr\Cache\CacheException
    {
    }
}
