<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper6ae4c4f86624\Symfony\Component\Cache;

use _PhpScoper6ae4c4f86624\Doctrine\Common\Cache\CacheProvider;
use _PhpScoper6ae4c4f86624\Psr\Cache\CacheItemPoolInterface;
use _PhpScoper6ae4c4f86624\Symfony\Contracts\Service\ResetInterface;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DoctrineProvider extends \_PhpScoper6ae4c4f86624\Doctrine\Common\Cache\CacheProvider implements \_PhpScoper6ae4c4f86624\Symfony\Component\Cache\PruneableInterface, \_PhpScoper6ae4c4f86624\Symfony\Component\Cache\ResettableInterface
{
    private $pool;
    public function __construct(\_PhpScoper6ae4c4f86624\Psr\Cache\CacheItemPoolInterface $pool)
    {
        $this->pool = $pool;
    }
    /**
     * {@inheritdoc}
     */
    public function prune()
    {
        return $this->pool instanceof \_PhpScoper6ae4c4f86624\Symfony\Component\Cache\PruneableInterface && $this->pool->prune();
    }
    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        if ($this->pool instanceof \_PhpScoper6ae4c4f86624\Symfony\Contracts\Service\ResetInterface) {
            $this->pool->reset();
        }
        $this->setNamespace($this->getNamespace());
    }
    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        $item = $this->pool->getItem(\rawurlencode($id));
        return $item->isHit() ? $item->get() : \false;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doContains($id)
    {
        return $this->pool->hasItem(\rawurlencode($id));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        $item = $this->pool->getItem(\rawurlencode($id));
        if (0 < $lifeTime) {
            $item->expiresAfter($lifeTime);
        }
        return $this->pool->save($item->set($data));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doDelete($id)
    {
        return $this->pool->deleteItem(\rawurlencode($id));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doFlush()
    {
        return $this->pool->clear();
    }
    /**
     * {@inheritdoc}
     *
     * @return array|null
     */
    protected function doGetStats()
    {
        return null;
    }
}
