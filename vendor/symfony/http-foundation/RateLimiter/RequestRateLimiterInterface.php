<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper45e499ef5890\Symfony\Component\HttpFoundation\RateLimiter;

use _PhpScoper45e499ef5890\Symfony\Component\HttpFoundation\Request;
use _PhpScoper45e499ef5890\Symfony\Component\RateLimiter\RateLimit;
/**
 * A special type of limiter that deals with requests.
 *
 * This allows to limit on different types of information
 * from the requests.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 *
 * @experimental in 5.2
 */
interface RequestRateLimiterInterface
{
    public function consume(\_PhpScoper45e499ef5890\Symfony\Component\HttpFoundation\Request $request) : \_PhpScoper45e499ef5890\Symfony\Component\RateLimiter\RateLimit;
    public function reset(\_PhpScoper45e499ef5890\Symfony\Component\HttpFoundation\Request $request) : void;
}
