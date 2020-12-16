<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperb6a8e65b492c\Symfony\Component\Cache\Exception;

use _PhpScoperb6a8e65b492c\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use _PhpScoperb6a8e65b492c\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperb6a8e65b492c\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoperb6a8e65b492c\Psr\Cache\InvalidArgumentException, \_PhpScoperb6a8e65b492c\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoperb6a8e65b492c\Psr\Cache\InvalidArgumentException
    {
    }
}
