<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfb2c402b972b\Symfony\Component\Cache\Adapter;

use _PhpScoperfb2c402b972b\Psr\Cache\CacheItemPoolInterface;
use _PhpScoperfb2c402b972b\Symfony\Component\Cache\CacheItem;
/**
 * Interface for adapters managing instances of Symfony's CacheItem.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface AdapterInterface extends \_PhpScoperfb2c402b972b\Psr\Cache\CacheItemPoolInterface
{
    /**
     * {@inheritdoc}
     *
     * @return CacheItem
     */
    public function getItem($key);
    /**
     * {@inheritdoc}
     *
     * @return \Traversable|CacheItem[]
     */
    public function getItems(array $keys = []);
    /**
     * {@inheritdoc}
     *
     * @param string $prefix
     *
     * @return bool
     */
    public function clear();
}
