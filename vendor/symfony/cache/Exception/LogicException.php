<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperaac5f7c652e4\Symfony\Component\Cache\Exception;

use _PhpScoperaac5f7c652e4\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoperaac5f7c652e4\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperaac5f7c652e4\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \_PhpScoperaac5f7c652e4\Psr\Cache\CacheException, \_PhpScoperaac5f7c652e4\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \_PhpScoperaac5f7c652e4\Psr\Cache\CacheException
    {
    }
}
