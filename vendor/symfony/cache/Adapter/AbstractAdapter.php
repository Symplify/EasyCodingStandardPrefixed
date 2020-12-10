<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Adapter;

use _PhpScoperfab1bfb7ec99\Psr\Log\LoggerAwareInterface;
use _PhpScoperfab1bfb7ec99\Psr\Log\LoggerInterface;
use _PhpScoperfab1bfb7ec99\Psr\Log\NullLogger;
use _PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem;
use _PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Exception\InvalidArgumentException;
use _PhpScoperfab1bfb7ec99\Symfony\Component\Cache\ResettableInterface;
use _PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Traits\AbstractAdapterTrait;
use _PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Traits\ContractsTrait;
use _PhpScoperfab1bfb7ec99\Symfony\Contracts\Cache\CacheInterface;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractAdapter implements \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Adapter\AdapterInterface, \_PhpScoperfab1bfb7ec99\Symfony\Contracts\Cache\CacheInterface, \_PhpScoperfab1bfb7ec99\Psr\Log\LoggerAwareInterface, \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\ResettableInterface
{
    /**
     * @internal
     */
    protected const NS_SEPARATOR = ':';
    use AbstractAdapterTrait;
    use ContractsTrait;
    private static $apcuSupported;
    private static $phpFilesSupported;
    protected function __construct(string $namespace = '', int $defaultLifetime = 0)
    {
        $this->namespace = '' === $namespace ? '' : \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem::validateKey($namespace) . static::NS_SEPARATOR;
        if (null !== $this->maxIdLength && \strlen($namespace) > $this->maxIdLength - 24) {
            throw new \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Namespace must be %d chars max, %d given ("%s")', $this->maxIdLength - 24, \strlen($namespace), $namespace));
        }
        $this->createCacheItem = \Closure::bind(static function ($key, $value, $isHit) use($defaultLifetime) {
            $item = new \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem();
            $item->key = $key;
            $item->value = $v = $value;
            $item->isHit = $isHit;
            $item->defaultLifetime = $defaultLifetime;
            // Detect wrapped values that encode for their expiry and creation duration
            // For compactness, these values are packed in the key of an array using
            // magic numbers in the form 9D-..-..-..-..-00-..-..-..-5F
            if (\is_array($v) && 1 === \count($v) && 10 === \strlen($k = \key($v)) && "�" === $k[0] && "\0" === $k[5] && "_" === $k[9]) {
                $item->value = $v[$k];
                $v = \unpack('Ve/Nc', \substr($k, 1, -1));
                $item->metadata[\_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY] = $v['e'] + \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY_OFFSET;
                $item->metadata[\_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem::METADATA_CTIME] = $v['c'];
            }
            return $item;
        }, null, \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem::class);
        $getId = \Closure::fromCallable([$this, 'getId']);
        $this->mergeByLifetime = \Closure::bind(static function ($deferred, $namespace, &$expiredIds) use($getId) {
            $byLifetime = [];
            $now = \microtime(\true);
            $expiredIds = [];
            foreach ($deferred as $key => $item) {
                $key = (string) $key;
                if (null === $item->expiry) {
                    $ttl = 0 < $item->defaultLifetime ? $item->defaultLifetime : 0;
                } elseif (0 >= ($ttl = (int) (0.1 + $item->expiry - $now))) {
                    $expiredIds[] = $getId($key);
                    continue;
                }
                if (isset(($metadata = $item->newMetadata)[\_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem::METADATA_TAGS])) {
                    unset($metadata[\_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem::METADATA_TAGS]);
                }
                // For compactness, expiry and creation duration are packed in the key of an array, using magic numbers as separators
                $byLifetime[$ttl][$getId($key)] = $metadata ? ["�" . \pack('VN', (int) (0.1 + $metadata[self::METADATA_EXPIRY] - self::METADATA_EXPIRY_OFFSET), $metadata[self::METADATA_CTIME]) . "_" => $item->value] : $item->value;
            }
            return $byLifetime;
        }, null, \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem::class);
    }
    /**
     * Returns the best possible adapter that your runtime supports.
     *
     * Using ApcuAdapter makes system caches compatible with read-only filesystems.
     *
     * @param string $namespace
     * @param int    $defaultLifetime
     * @param string $version
     * @param string $directory
     *
     * @return AdapterInterface
     */
    public static function createSystemCache($namespace, $defaultLifetime, $version, $directory, \_PhpScoperfab1bfb7ec99\Psr\Log\LoggerInterface $logger = null)
    {
        $opcache = new \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Adapter\PhpFilesAdapter($namespace, $defaultLifetime, $directory, \true);
        if (null !== $logger) {
            $opcache->setLogger($logger);
        }
        if (!(self::$apcuSupported = self::$apcuSupported ?? \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Adapter\ApcuAdapter::isSupported())) {
            return $opcache;
        }
        $apcu = new \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Adapter\ApcuAdapter($namespace, (int) $defaultLifetime / 5, $version);
        if ('cli' === \PHP_SAPI && !\filter_var(\ini_get('apc.enable_cli'), \FILTER_VALIDATE_BOOLEAN)) {
            $apcu->setLogger(new \_PhpScoperfab1bfb7ec99\Psr\Log\NullLogger());
        } elseif (null !== $logger) {
            $apcu->setLogger($logger);
        }
        return new \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Adapter\ChainAdapter([$apcu, $opcache]);
    }
    public static function createConnection($dsn, array $options = [])
    {
        if (!\is_string($dsn)) {
            throw new \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('The %s() method expect argument #1 to be string, %s given.', __METHOD__, \gettype($dsn)));
        }
        if (0 === \strpos($dsn, 'redis:') || 0 === \strpos($dsn, 'rediss:')) {
            return \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Adapter\RedisAdapter::createConnection($dsn, $options);
        }
        if (0 === \strpos($dsn, 'memcached:')) {
            return \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Adapter\MemcachedAdapter::createConnection($dsn, $options);
        }
        throw new \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Unsupported DSN: %s.', $dsn));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function commit()
    {
        $ok = \true;
        $byLifetime = $this->mergeByLifetime;
        $byLifetime = $byLifetime($this->deferred, $this->namespace, $expiredIds);
        $retry = $this->deferred = [];
        if ($expiredIds) {
            $this->doDelete($expiredIds);
        }
        foreach ($byLifetime as $lifetime => $values) {
            try {
                $e = $this->doSave($values, $lifetime);
            } catch (\Exception $e) {
            }
            if (\true === $e || [] === $e) {
                continue;
            }
            if (\is_array($e) || 1 === \count($values)) {
                foreach (\is_array($e) ? $e : \array_keys($values) as $id) {
                    $ok = \false;
                    $v = $values[$id];
                    $type = \is_object($v) ? \get_class($v) : \gettype($v);
                    $message = \sprintf('Failed to save key "{key}" of type %s%s', $type, $e instanceof \Exception ? ': ' . $e->getMessage() : '.');
                    \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem::log($this->logger, $message, ['key' => \substr($id, \strlen($this->namespace)), 'exception' => $e instanceof \Exception ? $e : null]);
                }
            } else {
                foreach ($values as $id => $v) {
                    $retry[$lifetime][] = $id;
                }
            }
        }
        // When bulk-save failed, retry each item individually
        foreach ($retry as $lifetime => $ids) {
            foreach ($ids as $id) {
                try {
                    $v = $byLifetime[$lifetime][$id];
                    $e = $this->doSave([$id => $v], $lifetime);
                } catch (\Exception $e) {
                }
                if (\true === $e || [] === $e) {
                    continue;
                }
                $ok = \false;
                $type = \is_object($v) ? \get_class($v) : \gettype($v);
                $message = \sprintf('Failed to save key "{key}" of type %s%s', $type, $e instanceof \Exception ? ': ' . $e->getMessage() : '.');
                \_PhpScoperfab1bfb7ec99\Symfony\Component\Cache\CacheItem::log($this->logger, $message, ['key' => \substr($id, \strlen($this->namespace)), 'exception' => $e instanceof \Exception ? $e : null]);
            }
        }
        return $ok;
    }
}
