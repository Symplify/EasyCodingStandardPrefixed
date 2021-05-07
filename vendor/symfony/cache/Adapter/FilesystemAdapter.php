<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210507\Symfony\Component\Cache\Adapter;

use ECSPrefix20210507\Symfony\Component\Cache\Marshaller\DefaultMarshaller;
use ECSPrefix20210507\Symfony\Component\Cache\Marshaller\MarshallerInterface;
use ECSPrefix20210507\Symfony\Component\Cache\PruneableInterface;
use ECSPrefix20210507\Symfony\Component\Cache\Traits\FilesystemTrait;
class FilesystemAdapter extends \ECSPrefix20210507\Symfony\Component\Cache\Adapter\AbstractAdapter implements PruneableInterface
{
    use FilesystemTrait;
    /**
     * @param string $namespace
     * @param int $defaultLifetime
     * @param string $directory
     * @param \ECSPrefix20210507\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller
     */
    public function __construct($namespace = '', $defaultLifetime = 0, $directory = null, $marshaller = null)
    {
        $this->marshaller = isset($marshaller) ? $marshaller : new DefaultMarshaller();
        parent::__construct('', $defaultLifetime);
        $this->init($namespace, $directory);
    }
}
