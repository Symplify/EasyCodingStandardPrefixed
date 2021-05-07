<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210507\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use ECSPrefix20210507\Symfony\Component\HttpFoundation\Request;
use ECSPrefix20210507\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use ECSPrefix20210507\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use ECSPrefix20210507\Symfony\Component\Stopwatch\Stopwatch;
/**
 * Provides timing information via the stopwatch.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class TraceableValueResolver implements ArgumentValueResolverInterface
{
    private $inner;
    private $stopwatch;
    /**
     * @param \ECSPrefix20210507\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface $inner
     * @param \ECSPrefix20210507\Symfony\Component\Stopwatch\Stopwatch $stopwatch
     */
    public function __construct($inner, $stopwatch)
    {
        $this->inner = $inner;
        $this->stopwatch = $stopwatch;
    }
    /**
     * {@inheritdoc}
     * @param \ECSPrefix20210507\Symfony\Component\HttpFoundation\Request $request
     * @param \ECSPrefix20210507\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument
     * @return bool
     */
    public function supports($request, $argument)
    {
        $method = \get_class($this->inner) . '::' . __FUNCTION__;
        $this->stopwatch->start($method, 'controller.argument_value_resolver');
        $return = $this->inner->supports($request, $argument);
        $this->stopwatch->stop($method);
        return $return;
    }
    /**
     * {@inheritdoc}
     * @return mixed[]
     * @param \ECSPrefix20210507\Symfony\Component\HttpFoundation\Request $request
     * @param \ECSPrefix20210507\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument
     */
    public function resolve($request, $argument)
    {
        $method = \get_class($this->inner) . '::' . __FUNCTION__;
        $this->stopwatch->start($method, 'controller.argument_value_resolver');
        yield from $this->inner->resolve($request, $argument);
        $this->stopwatch->stop($method);
    }
}
