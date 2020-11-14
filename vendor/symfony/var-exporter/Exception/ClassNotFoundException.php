<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperb09c3ec8e01a\Symfony\Component\VarExporter\Exception;

class ClassNotFoundException extends \Exception implements \_PhpScoperb09c3ec8e01a\Symfony\Component\VarExporter\Exception\ExceptionInterface
{
    public function __construct(string $class, \Throwable $previous = null)
    {
        parent::__construct(\sprintf('Class "%s" not found.', $class), 0, $previous);
    }
}
