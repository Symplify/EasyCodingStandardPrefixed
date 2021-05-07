<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210507\Symfony\Contracts\Cache;

use ECSPrefix20210507\Psr\Cache\CacheItemPoolInterface;
use ECSPrefix20210507\Psr\Cache\InvalidArgumentException;
use ECSPrefix20210507\Psr\Log\LoggerInterface;
// Help opcache.preload discover always-needed symbols
\class_exists(InvalidArgumentException::class);
/**
 * An implementation of CacheInterface for PSR-6 CacheItemPoolInterface classes.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
trait CacheTrait
{
    /**
     * {@inheritdoc}
     * @param string $key
     * @param float $beta
     */
    public function get($key, callable $callback, $beta = null, array &$metadata = null)
    {
        return $this->doGet($this, $key, $callback, $beta, $metadata);
    }
    /**
     * {@inheritdoc}
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return $this->deleteItem($key);
    }
    /**
     * @param float|null $beta
     * @param \ECSPrefix20210507\Psr\Cache\CacheItemPoolInterface $pool
     * @param string $key
     * @param \ECSPrefix20210507\Psr\Log\LoggerInterface $logger
     */
    private function doGet($pool, $key, callable $callback, $beta, array &$metadata = null, $logger = null)
    {
        if (0 > ($beta = isset($beta) ? $beta : 1.0)) {
            class AnonymousFor_NotInFunction extends \InvalidArgumentException implements InvalidArgumentException
            {
            }
            throw new AnonymousFor_NotInFunction(\sprintf('Argument "$beta" provided to "%s::get()" must be a positive number, %f given.', static::class, $beta));
        }
        $item = $pool->getItem($key);
        $recompute = !$item->isHit() || \INF === $beta;
        $metadata = $item instanceof \ECSPrefix20210507\Symfony\Contracts\Cache\ItemInterface ? $item->getMetadata() : [];
        if (!$recompute && $metadata) {
            $expiry = isset($metadata[\ECSPrefix20210507\Symfony\Contracts\Cache\ItemInterface::METADATA_EXPIRY]) ? $metadata[\ECSPrefix20210507\Symfony\Contracts\Cache\ItemInterface::METADATA_EXPIRY] : \false;
            $ctime = isset($metadata[\ECSPrefix20210507\Symfony\Contracts\Cache\ItemInterface::METADATA_CTIME]) ? $metadata[\ECSPrefix20210507\Symfony\Contracts\Cache\ItemInterface::METADATA_CTIME] : \false;
            if ($recompute = $ctime && $expiry && $expiry <= ($now = \microtime(\true)) - $ctime / 1000 * $beta * \log(\random_int(1, \PHP_INT_MAX) / \PHP_INT_MAX)) {
                // force applying defaultLifetime to expiry
                $item->expiresAt(null);
                $logger && $logger->info('Item "{key}" elected for early recomputation {delta}s before its expiration', ['key' => $key, 'delta' => \sprintf('%.1f', $expiry - $now)]);
            }
        }
        if ($recompute) {
            $save = \true;
            $item->set($callback($item, $save));
            if ($save) {
                $pool->save($item);
            }
        }
        return $item->get();
    }
}
