<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper28ab463fc3ba\Symfony\Component\Config\Loader;

/**
 * GlobFileLoader loads files from a glob pattern.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class GlobFileLoader extends \_PhpScoper28ab463fc3ba\Symfony\Component\Config\Loader\FileLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($resource, string $type = null)
    {
        return $this->import($resource);
    }
    /**
     * {@inheritdoc}
     */
    public function supports($resource, string $type = null)
    {
        return 'glob' === $type;
    }
}
