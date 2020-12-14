<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper6224e3b16fcc\Symfony\Component\Cache\Exception;

use _PhpScoper6224e3b16fcc\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use _PhpScoper6224e3b16fcc\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoper6224e3b16fcc\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoper6224e3b16fcc\Psr\Cache\InvalidArgumentException, \_PhpScoper6224e3b16fcc\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoper6224e3b16fcc\Psr\Cache\InvalidArgumentException
    {
    }
}
