<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperc75fd40d7a6e\Symfony\Component\Cache\Adapter;

use _PhpScoperc75fd40d7a6e\Symfony\Contracts\Cache\TagAwareCacheInterface;
/**
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class TraceableTagAwareAdapter extends \_PhpScoperc75fd40d7a6e\Symfony\Component\Cache\Adapter\TraceableAdapter implements \_PhpScoperc75fd40d7a6e\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface, \_PhpScoperc75fd40d7a6e\Symfony\Contracts\Cache\TagAwareCacheInterface
{
    public function __construct(\_PhpScoperc75fd40d7a6e\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface $pool)
    {
        parent::__construct($pool);
    }
    /**
     * {@inheritdoc}
     */
    public function invalidateTags(array $tags)
    {
        $event = $this->start(__FUNCTION__);
        try {
            return $event->result = $this->pool->invalidateTags($tags);
        } finally {
            $event->end = \microtime(\true);
        }
    }
}
