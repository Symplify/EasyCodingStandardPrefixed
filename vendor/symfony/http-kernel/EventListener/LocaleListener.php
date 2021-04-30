<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopera658fe86acec\Symfony\Component\HttpKernel\EventListener;

use _PhpScopera658fe86acec\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use _PhpScopera658fe86acec\Symfony\Component\HttpFoundation\Request;
use _PhpScopera658fe86acec\Symfony\Component\HttpFoundation\RequestStack;
use _PhpScopera658fe86acec\Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use _PhpScopera658fe86acec\Symfony\Component\HttpKernel\Event\KernelEvent;
use _PhpScopera658fe86acec\Symfony\Component\HttpKernel\Event\RequestEvent;
use _PhpScopera658fe86acec\Symfony\Component\HttpKernel\KernelEvents;
use _PhpScopera658fe86acec\Symfony\Component\Routing\RequestContextAwareInterface;
/**
 * Initializes the locale based on the current request.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class LocaleListener implements EventSubscriberInterface
{
    private $router;
    private $defaultLocale;
    private $requestStack;
    public function __construct(RequestStack $requestStack, string $defaultLocale = 'en', RequestContextAwareInterface $router = null)
    {
        $this->defaultLocale = $defaultLocale;
        $this->requestStack = $requestStack;
        $this->router = $router;
    }
    public function setDefaultLocale(KernelEvent $event)
    {
        $event->getRequest()->setDefaultLocale($this->defaultLocale);
    }
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $this->setLocale($request);
        $this->setRouterContext($request);
    }
    public function onKernelFinishRequest(FinishRequestEvent $event)
    {
        if (null !== ($parentRequest = $this->requestStack->getParentRequest())) {
            $this->setRouterContext($parentRequest);
        }
    }
    private function setLocale(Request $request)
    {
        if ($locale = $request->attributes->get('_locale')) {
            $request->setLocale($locale);
        }
    }
    private function setRouterContext(Request $request)
    {
        if (null !== $this->router) {
            $this->router->getContext()->setParameter('_locale', $request->getLocale());
        }
    }
    public static function getSubscribedEvents() : array
    {
        return [KernelEvents::REQUEST => [
            ['setDefaultLocale', 100],
            // must be registered after the Router to have access to the _locale
            ['onKernelRequest', 16],
        ], KernelEvents::FINISH_REQUEST => [['onKernelFinishRequest', 0]]];
    }
}
