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

use ECSPrefix20210507\Psr\Log\LoggerInterface;
use ECSPrefix20210507\Symfony\Component\Debug\Exception\FlattenException as LegacyFlattenException;
use ECSPrefix20210507\Symfony\Component\ErrorHandler\Exception\FlattenException;
use ECSPrefix20210507\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ECSPrefix20210507\Symfony\Component\HttpFoundation\Request;
use ECSPrefix20210507\Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use ECSPrefix20210507\Symfony\Component\HttpKernel\Event\ExceptionEvent;
use ECSPrefix20210507\Symfony\Component\HttpKernel\Event\ResponseEvent;
use ECSPrefix20210507\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use ECSPrefix20210507\Symfony\Component\HttpKernel\HttpKernelInterface;
use ECSPrefix20210507\Symfony\Component\HttpKernel\KernelEvents;
use ECSPrefix20210507\Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ErrorListener implements EventSubscriberInterface
{
    protected $controller;
    protected $logger;
    protected $debug;
    /**
     * @param \ECSPrefix20210507\Psr\Log\LoggerInterface $logger
     * @param bool $debug
     */
    public function __construct($controller, $logger = null, $debug = \false)
    {
        $this->controller = $controller;
        $this->logger = $logger;
        $this->debug = $debug;
    }
    /**
     * @param \ECSPrefix20210507\Symfony\Component\HttpKernel\Event\ExceptionEvent $event
     */
    public function logKernelException($event)
    {
        $e = FlattenException::createFromThrowable($event->getThrowable());
        $this->logException($event->getThrowable(), \sprintf('Uncaught PHP Exception %s: "%s" at %s line %s', $e->getClass(), $e->getMessage(), $e->getFile(), $e->getLine()));
    }
    /**
     * @param \ECSPrefix20210507\Symfony\Component\HttpKernel\Event\ExceptionEvent $event
     */
    public function onKernelException($event)
    {
        if (null === $this->controller) {
            return;
        }
        $exception = $event->getThrowable();
        $request = $this->duplicateRequest($exception, $event->getRequest());
        try {
            $response = $event->getKernel()->handle($request, HttpKernelInterface::SUB_REQUEST, \false);
        } catch (\Exception $e) {
            $f = FlattenException::createFromThrowable($e);
            $this->logException($e, \sprintf('Exception thrown when handling an exception (%s: %s at %s line %s)', $f->getClass(), $f->getMessage(), $e->getFile(), $e->getLine()));
            $prev = $e;
            do {
                if ($exception === ($wrapper = $prev)) {
                    throw $e;
                }
            } while ($prev = $wrapper->getPrevious());
            $prev = new \ReflectionProperty($wrapper instanceof \Exception ? \Exception::class : \Error::class, 'previous');
            $prev->setAccessible(\true);
            $prev->setValue($wrapper, $exception);
            throw $e;
        }
        $event->setResponse($response);
        if ($this->debug) {
            $event->getRequest()->attributes->set('_remove_csp_headers', \true);
        }
    }
    /**
     * @return void
     * @param \ECSPrefix20210507\Symfony\Component\HttpKernel\Event\ResponseEvent $event
     */
    public function removeCspHeader($event)
    {
        if ($this->debug && $event->getRequest()->attributes->get('_remove_csp_headers', \false)) {
            $event->getResponse()->headers->remove('Content-Security-Policy');
        }
    }
    /**
     * @param \ECSPrefix20210507\Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent $event
     */
    public function onControllerArguments($event)
    {
        $e = $event->getRequest()->attributes->get('exception');
        if (!$e instanceof \Throwable || \false === ($k = \array_search($e, $event->getArguments(), \true))) {
            return;
        }
        $r = new \ReflectionFunction(\Closure::fromCallable($event->getController()));
        $r = isset($r->getParameters()[$k]) ? $r->getParameters()[$k] : null;
        if ($r && (!($r = $r->getType()) instanceof \ReflectionNamedType || \in_array($r->getName(), [FlattenException::class, LegacyFlattenException::class], \true))) {
            $arguments = $event->getArguments();
            $arguments[$k] = FlattenException::createFromThrowable($e);
            $event->setArguments($arguments);
        }
    }
    /**
     * @return mixed[]
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER_ARGUMENTS => 'onControllerArguments', KernelEvents::EXCEPTION => [['logKernelException', 0], ['onKernelException', -128]], KernelEvents::RESPONSE => ['removeCspHeader', -128]];
    }
    /**
     * Logs an exception.
     * @return void
     * @param \Throwable $exception
     * @param string $message
     */
    protected function logException($exception, $message)
    {
        if (null !== $this->logger) {
            if (!$exception instanceof HttpExceptionInterface || $exception->getStatusCode() >= 500) {
                $this->logger->critical($message, ['exception' => $exception]);
            } else {
                $this->logger->error($message, ['exception' => $exception]);
            }
        }
    }
    /**
     * Clones the request for the exception.
     * @param \Throwable $exception
     * @param \ECSPrefix20210507\Symfony\Component\HttpFoundation\Request $request
     * @return \ECSPrefix20210507\Symfony\Component\HttpFoundation\Request
     */
    protected function duplicateRequest($exception, $request)
    {
        $attributes = ['_controller' => $this->controller, 'exception' => $exception, 'logger' => $this->logger instanceof DebugLoggerInterface ? $this->logger : null];
        $request = $request->duplicate(null, null, $attributes);
        $request->setMethod('GET');
        return $request;
    }
}
