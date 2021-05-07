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

use ECSPrefix20210507\Psr\Container\ContainerInterface;
use ECSPrefix20210507\Symfony\Component\HttpFoundation\Session\SessionInterface;
use ECSPrefix20210507\Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use ECSPrefix20210507\Symfony\Component\HttpKernel\Event\RequestEvent;
/**
 * Sets the session in the request.
 *
 * When the passed container contains a "session_storage" entry which
 * holds a NativeSessionStorage instance, the "cookie_secure" option
 * will be set to true whenever the current master request is secure.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class SessionListener extends \ECSPrefix20210507\Symfony\Component\HttpKernel\EventListener\AbstractSessionListener
{
    /**
     * @param \ECSPrefix20210507\Psr\Container\ContainerInterface $container
     * @param bool $debug
     */
    public function __construct($container, $debug = \false)
    {
        parent::__construct($container, $debug);
    }
    /**
     * @param \ECSPrefix20210507\Symfony\Component\HttpKernel\Event\RequestEvent $event
     */
    public function onKernelRequest($event)
    {
        parent::onKernelRequest($event);
        if (!$event->isMasterRequest() || !$this->container->has('session')) {
            return;
        }
        if ($this->container->has('session_storage') && ($storage = $this->container->get('session_storage')) instanceof NativeSessionStorage && ($masterRequest = $this->container->get('request_stack')->getMasterRequest()) && $masterRequest->isSecure()) {
            $storage->setOptions(['cookie_secure' => \true]);
        }
    }
    /**
     * @return \ECSPrefix20210507\Symfony\Component\HttpFoundation\Session\SessionInterface|null
     */
    protected function getSession()
    {
        if (!$this->container->has('session')) {
            return null;
        }
        return $this->container->get('session');
    }
}
