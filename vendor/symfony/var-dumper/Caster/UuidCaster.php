<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopera658fe86acec\Symfony\Component\VarDumper\Caster;

use _PhpScopera658fe86acec\Ramsey\Uuid\UuidInterface;
use _PhpScopera658fe86acec\Symfony\Component\VarDumper\Cloner\Stub;
/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
final class UuidCaster
{
    public static function castRamseyUuid(UuidInterface $c, array $a, Stub $stub, bool $isNested) : array
    {
        $a += [\_PhpScopera658fe86acec\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'uuid' => (string) $c];
        return $a;
    }
}
