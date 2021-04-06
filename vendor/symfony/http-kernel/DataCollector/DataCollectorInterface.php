<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperb6361033cf41\Symfony\Component\HttpKernel\DataCollector;

use _PhpScoperb6361033cf41\Symfony\Component\HttpFoundation\Request;
use _PhpScoperb6361033cf41\Symfony\Component\HttpFoundation\Response;
use _PhpScoperb6361033cf41\Symfony\Contracts\Service\ResetInterface;
/**
 * DataCollectorInterface.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface DataCollectorInterface extends \_PhpScoperb6361033cf41\Symfony\Contracts\Service\ResetInterface
{
    /**
     * Collects data for the given Request and Response.
     */
    public function collect(\_PhpScoperb6361033cf41\Symfony\Component\HttpFoundation\Request $request, \_PhpScoperb6361033cf41\Symfony\Component\HttpFoundation\Response $response, \Throwable $exception = null);
    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName();
}
