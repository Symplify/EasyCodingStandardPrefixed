<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperb44a315fec16\Symfony\Component\Cache\Exception;

use _PhpScoperb44a315fec16\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoperb44a315fec16\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperb44a315fec16\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \_PhpScoperb44a315fec16\Psr\Cache\CacheException, \_PhpScoperb44a315fec16\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \_PhpScoperb44a315fec16\Psr\Cache\CacheException
    {
    }
}
