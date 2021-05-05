<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperef2f7aa3581e\Symfony\Component\HttpKernel\EventListener;

use _PhpScoperef2f7aa3581e\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use _PhpScoperef2f7aa3581e\Symfony\Component\HttpKernel\Event\RequestEvent;
use _PhpScoperef2f7aa3581e\Symfony\Component\HttpKernel\KernelEvents;
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
     */
    public function onKernelRequest(RequestEvent $event)
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
     */
    public static function getSubscribedEvents() : array
    {
        return [KernelEvents::REQUEST => [['onKernelRequest', 256]]];
    }
}
