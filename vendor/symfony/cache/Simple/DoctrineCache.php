<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperb6ccec8ab642\Symfony\Component\Cache\Simple;

use _PhpScoperb6ccec8ab642\Doctrine\Common\Cache\CacheProvider;
use _PhpScoperb6ccec8ab642\Symfony\Component\Cache\Adapter\DoctrineAdapter;
use _PhpScoperb6ccec8ab642\Symfony\Component\Cache\Traits\DoctrineTrait;
use _PhpScoperb6ccec8ab642\Symfony\Contracts\Cache\CacheInterface;
@\trigger_error(\sprintf('The "%s" class is deprecated since Symfony 4.3, use "%s" and type-hint for "%s" instead.', \_PhpScoperb6ccec8ab642\Symfony\Component\Cache\Simple\DoctrineCache::class, \_PhpScoperb6ccec8ab642\Symfony\Component\Cache\Adapter\DoctrineAdapter::class, \_PhpScoperb6ccec8ab642\Symfony\Contracts\Cache\CacheInterface::class), \E_USER_DEPRECATED);
/**
 * @deprecated since Symfony 4.3, use DoctrineAdapter and type-hint for CacheInterface instead.
 */
class DoctrineCache extends \_PhpScoperb6ccec8ab642\Symfony\Component\Cache\Simple\AbstractCache
{
    use DoctrineTrait;
    public function __construct(\_PhpScoperb6ccec8ab642\Doctrine\Common\Cache\CacheProvider $provider, string $namespace = '', int $defaultLifetime = 0)
    {
        parent::__construct('', $defaultLifetime);
        $this->provider = $provider;
        $provider->setNamespace($namespace);
    }
}
