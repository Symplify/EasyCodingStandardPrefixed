<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfacc742d2745\Symfony\Component\HttpKernel\Controller;

use _PhpScoperfacc742d2745\Symfony\Component\HttpFoundation\Request;
/**
 * An ArgumentResolverInterface instance knows how to determine the
 * arguments for a specific action.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface ArgumentResolverInterface
{
    /**
     * Returns the arguments to pass to the controller.
     *
     * @param callable $controller
     *
     * @return array An array of arguments to pass to the controller
     *
     * @throws \RuntimeException When no value could be provided for a required argument
     */
    public function getArguments(\_PhpScoperfacc742d2745\Symfony\Component\HttpFoundation\Request $request, $controller);
}
