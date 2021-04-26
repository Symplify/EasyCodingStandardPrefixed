<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperd2a667bd5a98\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use _PhpScoperd2a667bd5a98\Symfony\Component\HttpFoundation\Request;
use _PhpScoperd2a667bd5a98\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use _PhpScoperd2a667bd5a98\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
/**
 * Yields the same instance as the request object passed along.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class RequestValueResolver implements ArgumentValueResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument) : bool
    {
        return Request::class === $argument->getType() || \is_subclass_of($argument->getType(), Request::class);
    }
    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument) : iterable
    {
        (yield $request);
    }
}
