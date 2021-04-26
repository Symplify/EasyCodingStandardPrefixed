<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperd51690aa3091\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use _PhpScoperd51690aa3091\Symfony\Component\HttpFoundation\Request;
use _PhpScoperd51690aa3091\Symfony\Component\HttpFoundation\Session\SessionInterface;
use _PhpScoperd51690aa3091\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use _PhpScoperd51690aa3091\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
/**
 * Yields the Session.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class SessionValueResolver implements ArgumentValueResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument) : bool
    {
        if (!$request->hasSession()) {
            return \false;
        }
        $type = $argument->getType();
        if (SessionInterface::class !== $type && !\is_subclass_of($type, SessionInterface::class)) {
            return \false;
        }
        return $request->getSession() instanceof $type;
    }
    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument) : iterable
    {
        (yield $request->getSession());
    }
}
