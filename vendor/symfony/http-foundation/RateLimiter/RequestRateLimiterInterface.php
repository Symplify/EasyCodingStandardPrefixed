<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperf3dc21757def\Symfony\Component\HttpFoundation\RateLimiter;

use _PhpScoperf3dc21757def\Symfony\Component\HttpFoundation\Request;
use _PhpScoperf3dc21757def\Symfony\Component\RateLimiter\RateLimit;
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
    public function consume(\_PhpScoperf3dc21757def\Symfony\Component\HttpFoundation\Request $request) : \_PhpScoperf3dc21757def\Symfony\Component\RateLimiter\RateLimit;
    public function reset(\_PhpScoperf3dc21757def\Symfony\Component\HttpFoundation\Request $request) : void;
}
