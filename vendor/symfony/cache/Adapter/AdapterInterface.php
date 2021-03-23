<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperf523baae4f87\Symfony\Component\Cache\Adapter;

use _PhpScoperf523baae4f87\Psr\Cache\CacheItemPoolInterface;
use _PhpScoperf523baae4f87\Symfony\Component\Cache\CacheItem;
// Help opcache.preload discover always-needed symbols
\class_exists(\_PhpScoperf523baae4f87\Symfony\Component\Cache\CacheItem::class);
/**
 * Interface for adapters managing instances of Symfony's CacheItem.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface AdapterInterface extends \_PhpScoperf523baae4f87\Psr\Cache\CacheItemPoolInterface
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
     * @return bool
     */
    public function clear(string $prefix = '');
}
