<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperf3d5f0921050\Symfony\Component\Mime\Tests;

use _PhpScoperf3d5f0921050\Symfony\Component\Mime\FileBinaryMimeTypeGuesser;
use _PhpScoperf3d5f0921050\Symfony\Component\Mime\MimeTypeGuesserInterface;
class FileBinaryMimeTypeGuesserTest extends \_PhpScoperf3d5f0921050\Symfony\Component\Mime\Tests\AbstractMimeTypeGuesserTest
{
    protected function getGuesser() : \_PhpScoperf3d5f0921050\Symfony\Component\Mime\MimeTypeGuesserInterface
    {
        return new \_PhpScoperf3d5f0921050\Symfony\Component\Mime\FileBinaryMimeTypeGuesser();
    }
}
