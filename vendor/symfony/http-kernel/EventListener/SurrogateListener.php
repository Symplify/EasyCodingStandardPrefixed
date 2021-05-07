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
use ECSPrefix20210507\Symfony\Component\HttpKernel\Event\ResponseEvent;
use ECSPrefix20210507\Symfony\Component\HttpKernel\HttpCache\HttpCache;
use ECSPrefix20210507\Symfony\Component\HttpKernel\HttpCache\SurrogateInterface;
use ECSPrefix20210507\Symfony\Component\HttpKernel\KernelEvents;
/**
 * SurrogateListener adds a Surrogate-Control HTTP header when the Response needs to be parsed for Surrogates.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class SurrogateListener implements EventSubscriberInterface
{
    private $surrogate;
    /**
     * @param \ECSPrefix20210507\Symfony\Component\HttpKernel\HttpCache\SurrogateInterface $surrogate
     */
    public function __construct($surrogate = null)
    {
        $this->surrogate = $surrogate;
    }
    /**
     * Filters the Response.
     * @param \ECSPrefix20210507\Symfony\Component\HttpKernel\Event\ResponseEvent $event
     */
    public function onKernelResponse($event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $kernel = $event->getKernel();
        $surrogate = $this->surrogate;
        if ($kernel instanceof HttpCache) {
            $surrogate = $kernel->getSurrogate();
            if (null !== $this->surrogate && $this->surrogate->getName() !== $surrogate->getName()) {
                $surrogate = $this->surrogate;
            }
        }
        if (null === $surrogate) {
            return;
        }
        $surrogate->addSurrogateControl($event->getResponse());
    }
    /**
     * @return mixed[]
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::RESPONSE => 'onKernelResponse'];
    }
}
