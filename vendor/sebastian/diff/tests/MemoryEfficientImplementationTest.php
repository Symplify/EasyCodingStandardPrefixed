<?php

declare (strict_types=1);
/*
 * This file is part of sebastian/diff.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper39d23eef9a06\SebastianBergmann\Diff;

/**
 * @covers SebastianBergmann\Diff\MemoryEfficientLongestCommonSubsequenceCalculator
 */
final class MemoryEfficientImplementationTest extends \_PhpScoper39d23eef9a06\SebastianBergmann\Diff\LongestCommonSubsequenceTest
{
    protected function createImplementation() : \_PhpScoper39d23eef9a06\SebastianBergmann\Diff\LongestCommonSubsequenceCalculator
    {
        return new \_PhpScoper39d23eef9a06\SebastianBergmann\Diff\MemoryEfficientLongestCommonSubsequenceCalculator();
    }
}
