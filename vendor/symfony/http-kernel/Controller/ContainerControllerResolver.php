<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper86aebf8cf357\Symfony\Component\HttpKernel\Controller;

use _PhpScoper86aebf8cf357\Psr\Container\ContainerInterface;
use _PhpScoper86aebf8cf357\Psr\Log\LoggerInterface;
use _PhpScoper86aebf8cf357\Symfony\Component\DependencyInjection\Container;
/**
 * A controller resolver searching for a controller in a psr-11 container when using the "service::method" notation.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Maxime Steinhausser <maxime.steinhausser@gmail.com>
 */
class ContainerControllerResolver extends \_PhpScoper86aebf8cf357\Symfony\Component\HttpKernel\Controller\ControllerResolver
{
    protected $container;
    public function __construct(\_PhpScoper86aebf8cf357\Psr\Container\ContainerInterface $container, \_PhpScoper86aebf8cf357\Psr\Log\LoggerInterface $logger = null)
    {
        $this->container = $container;
        parent::__construct($logger);
    }
    protected function createController(string $controller)
    {
        if (1 === \substr_count($controller, ':')) {
            $controller = \str_replace(':', '::', $controller);
            trigger_deprecation('symfony/http-kernel', '5.1', 'Referencing controllers with a single colon is deprecated. Use "%s" instead.', $controller);
        }
        return parent::createController($controller);
    }
    /**
     * {@inheritdoc}
     */
    protected function instantiateController(string $class)
    {
        $class = \ltrim($class, '\\');
        if ($this->container->has($class)) {
            return $this->container->get($class);
        }
        try {
            return parent::instantiateController($class);
        } catch (\Error $e) {
        }
        $this->throwExceptionIfControllerWasRemoved($class, $e);
        if ($e instanceof \ArgumentCountError) {
            throw new \InvalidArgumentException(\sprintf('Controller "%s" has required constructor arguments and does not exist in the container. Did you forget to define the controller as a service?', $class), 0, $e);
        }
        throw new \InvalidArgumentException(\sprintf('Controller "%s" does neither exist as service nor as class.', $class), 0, $e);
    }
    private function throwExceptionIfControllerWasRemoved(string $controller, \Throwable $previous)
    {
        if ($this->container instanceof \_PhpScoper86aebf8cf357\Symfony\Component\DependencyInjection\Container && isset($this->container->getRemovedIds()[$controller])) {
            throw new \InvalidArgumentException(\sprintf('Controller "%s" cannot be fetched from the container because it is private. Did you forget to tag the service with "controller.service_arguments"?', $controller), 0, $previous);
        }
    }
}
