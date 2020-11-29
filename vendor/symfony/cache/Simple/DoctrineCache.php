<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopercae980ebf12d\Symfony\Component\Cache\Simple;

use _PhpScopercae980ebf12d\Doctrine\Common\Cache\CacheProvider;
use _PhpScopercae980ebf12d\Symfony\Component\Cache\Adapter\DoctrineAdapter;
use _PhpScopercae980ebf12d\Symfony\Component\Cache\Traits\DoctrineTrait;
use _PhpScopercae980ebf12d\Symfony\Contracts\Cache\CacheInterface;
@\trigger_error(\sprintf('The "%s" class is deprecated since Symfony 4.3, use "%s" and type-hint for "%s" instead.', \_PhpScopercae980ebf12d\Symfony\Component\Cache\Simple\DoctrineCache::class, \_PhpScopercae980ebf12d\Symfony\Component\Cache\Adapter\DoctrineAdapter::class, \_PhpScopercae980ebf12d\Symfony\Contracts\Cache\CacheInterface::class), \E_USER_DEPRECATED);
/**
 * @deprecated since Symfony 4.3, use DoctrineAdapter and type-hint for CacheInterface instead.
 */
class DoctrineCache extends \_PhpScopercae980ebf12d\Symfony\Component\Cache\Simple\AbstractCache
{
    use DoctrineTrait;
    public function __construct(\_PhpScopercae980ebf12d\Doctrine\Common\Cache\CacheProvider $provider, string $namespace = '', int $defaultLifetime = 0)
    {
        parent::__construct('', $defaultLifetime);
        $this->provider = $provider;
        $provider->setNamespace($namespace);
    }
}
