<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper87c77ad5700d\Symfony\Component\Cache\Adapter;

use _PhpScoper87c77ad5700d\Psr\Cache\CacheItemInterface;
use _PhpScoper87c77ad5700d\Symfony\Component\Cache\CacheItem;
use _PhpScoper87c77ad5700d\Symfony\Contracts\Cache\CacheInterface;
/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class NullAdapter implements \_PhpScoper87c77ad5700d\Symfony\Component\Cache\Adapter\AdapterInterface, \_PhpScoper87c77ad5700d\Symfony\Contracts\Cache\CacheInterface
{
    private $createCacheItem;
    public function __construct()
    {
        $this->createCacheItem = \Closure::bind(function ($key) {
            $item = new \_PhpScoper87c77ad5700d\Symfony\Component\Cache\CacheItem();
            $item->key = $key;
            $item->isHit = \false;
            return $item;
        }, $this, \_PhpScoper87c77ad5700d\Symfony\Component\Cache\CacheItem::class);
    }
    /**
     * {@inheritdoc}
     */
    public function get(string $key, callable $callback, float $beta = null, array &$metadata = null)
    {
        $save = \true;
        return $callback(($this->createCacheItem)($key), $save);
    }
    /**
     * {@inheritdoc}
     */
    public function getItem($key)
    {
        $f = $this->createCacheItem;
        return $f($key);
    }
    /**
     * {@inheritdoc}
     */
    public function getItems(array $keys = [])
    {
        return $this->generateItems($keys);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function hasItem($key)
    {
        return \false;
    }
    /**
     * {@inheritdoc}
     *
     * @param string $prefix
     *
     * @return bool
     */
    public function clear()
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function deleteItem($key)
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function deleteItems(array $keys)
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function save(\_PhpScoper87c77ad5700d\Psr\Cache\CacheItemInterface $item)
    {
        return \false;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function saveDeferred(\_PhpScoper87c77ad5700d\Psr\Cache\CacheItemInterface $item)
    {
        return \false;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function commit()
    {
        return \false;
    }
    /**
     * {@inheritdoc}
     */
    public function delete(string $key) : bool
    {
        return $this->deleteItem($key);
    }
    private function generateItems(array $keys)
    {
        $f = $this->createCacheItem;
        foreach ($keys as $key) {
            (yield $key => $f($key));
        }
    }
}
