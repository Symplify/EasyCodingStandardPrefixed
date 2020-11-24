<?php

/*
 * This file is part of composer/semver.
 *
 * (c) Composer <https://github.com/composer>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace _PhpScoperf3d5f0921050\Composer\Semver\Constraint;

interface ConstraintInterface
{
    /**
     * @param ConstraintInterface $provider
     *
     * @return bool
     */
    public function matches(\_PhpScoperf3d5f0921050\Composer\Semver\Constraint\ConstraintInterface $provider);
    /**
     * @return string
     */
    public function getPrettyString();
    /**
     * @return string
     */
    public function __toString();
}
