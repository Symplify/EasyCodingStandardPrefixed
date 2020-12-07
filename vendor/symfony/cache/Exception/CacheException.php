<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperda2604e33acb\Symfony\Component\Cache\Exception;

use _PhpScoperda2604e33acb\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoperda2604e33acb\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperda2604e33acb\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \_PhpScoperda2604e33acb\Psr\Cache\CacheException, \_PhpScoperda2604e33acb\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \_PhpScoperda2604e33acb\Psr\Cache\CacheException
    {
    }
}
