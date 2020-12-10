<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper58a0a169dcfb\Symfony\Component\HttpKernel\DataCollector;

use _PhpScoper58a0a169dcfb\Symfony\Component\HttpFoundation\Request;
use _PhpScoper58a0a169dcfb\Symfony\Component\HttpFoundation\Response;
use _PhpScoper58a0a169dcfb\Symfony\Contracts\Service\ResetInterface;
/**
 * DataCollectorInterface.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface DataCollectorInterface extends \_PhpScoper58a0a169dcfb\Symfony\Contracts\Service\ResetInterface
{
    /**
     * Collects data for the given Request and Response.
     *
     * @param \Throwable|null $exception
     */
    public function collect(\_PhpScoper58a0a169dcfb\Symfony\Component\HttpFoundation\Request $request, \_PhpScoper58a0a169dcfb\Symfony\Component\HttpFoundation\Response $response);
    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName();
}
