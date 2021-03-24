<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperc98ae2003489\Symfony\Component\Console\CommandLoader;

use _PhpScoperc98ae2003489\Symfony\Component\Console\Command\Command;
use _PhpScoperc98ae2003489\Symfony\Component\Console\Exception\CommandNotFoundException;
/**
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
interface CommandLoaderInterface
{
    /**
     * Loads a command.
     *
     * @return Command
     *
     * @throws CommandNotFoundException
     */
    public function get(string $name);
    /**
     * Checks if a command exists.
     *
     * @return bool
     */
    public function has(string $name);
    /**
     * @return string[] All registered command names
     */
    public function getNames();
}
