<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper457dd3bd73ba\Symfony\Component\EventDispatcher;

use _PhpScoper457dd3bd73ba\Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
trigger_deprecation('symfony/event-dispatcher', '5.1', '%s is deprecated, use the event dispatcher without the proxy.', \_PhpScoper457dd3bd73ba\Symfony\Component\EventDispatcher\LegacyEventDispatcherProxy::class);
/**
 * A helper class to provide BC/FC with the legacy signature of EventDispatcherInterface::dispatch().
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @deprecated since Symfony 5.1
 */
final class LegacyEventDispatcherProxy
{
    public static function decorate(?\_PhpScoper457dd3bd73ba\Symfony\Contracts\EventDispatcher\EventDispatcherInterface $dispatcher) : ?\_PhpScoper457dd3bd73ba\Symfony\Contracts\EventDispatcher\EventDispatcherInterface
    {
        return $dispatcher;
    }
}
