<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Cache;

/**
 * @author Andreas Möller <am@localheinz.com>
 *
 * @internal
 */
interface CacheInterface
{
    /**
     * @return \PhpCsFixer\Cache\SignatureInterface
     */
    public function getSignature();
    /**
     * @param string $file
     * @return bool
     */
    public function has($file);
    /**
     * @return int|null
     * @param string $file
     */
    public function get($file);
    /**
     * @return void
     * @param string $file
     * @param int $hash
     */
    public function set($file, $hash);
    /**
     * @return void
     * @param string $file
     */
    public function clear($file);
    /**
     * @return string
     */
    public function toJson();
}
