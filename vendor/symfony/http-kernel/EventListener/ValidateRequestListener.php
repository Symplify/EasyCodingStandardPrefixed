<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210507\Symfony\Component\HttpKernel\EventListener;

use ECSPrefix20210507\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ECSPrefix20210507\Symfony\Component\HttpKernel\Event\RequestEvent;
use ECSPrefix20210507\Symfony\Component\HttpKernel\KernelEvents;
/**
 * Validates Requests.
 *
 * @author Magnus Nordlander <magnus@fervo.se>
 *
 * @final
 */
class ValidateRequestListener implements EventSubscriberInterface
{
    /**
     * Performs the validation.
     * @param \ECSPrefix20210507\Symfony\Component\HttpKernel\Event\RequestEvent $event
     */
    public function onKernelRequest($event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();
        if ($request::getTrustedProxies()) {
            $request->getClientIps();
        }
        $request->getHost();
    }
    /**
     * {@inheritdoc}
     * @return mixed[]
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => [['onKernelRequest', 256]]];
    }
}
