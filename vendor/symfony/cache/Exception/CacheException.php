<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfa7254c25e18\Symfony\Component\Cache\Exception;

use _PhpScoperfa7254c25e18\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoperfa7254c25e18\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperfa7254c25e18\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \_PhpScoperfa7254c25e18\Psr\Cache\CacheException, \_PhpScoperfa7254c25e18\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \_PhpScoperfa7254c25e18\Psr\Cache\CacheException
    {
    }
}
