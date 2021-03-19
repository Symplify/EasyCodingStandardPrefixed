<?php

/*
 * This file is part of composer/semver.
 *
 * (c) Composer <https://github.com/composer>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace _PhpScoperd47a2fa2a77e\Composer\Semver;

use _PhpScoperd47a2fa2a77e\Composer\Semver\Constraint\Constraint;
use _PhpScoperd47a2fa2a77e\Composer\Semver\Constraint\ConstraintInterface;
/**
 * Helper class to evaluate constraint by compiling and reusing the code to evaluate
 */
class CompilingMatcher
{
    private static $compiledCheckerCache = array();
    private static $enabled;
    /**
     * @phpstan-var array<Constraint::OP_*, string>
     */
    private static $transOpInt = array(\_PhpScoperd47a2fa2a77e\Composer\Semver\Constraint\Constraint::OP_EQ => '==', \_PhpScoperd47a2fa2a77e\Composer\Semver\Constraint\Constraint::OP_LT => '<', \_PhpScoperd47a2fa2a77e\Composer\Semver\Constraint\Constraint::OP_LE => '<=', \_PhpScoperd47a2fa2a77e\Composer\Semver\Constraint\Constraint::OP_GT => '>', \_PhpScoperd47a2fa2a77e\Composer\Semver\Constraint\Constraint::OP_GE => '>=', \_PhpScoperd47a2fa2a77e\Composer\Semver\Constraint\Constraint::OP_NE => '!=');
    /**
     * Evaluates the expression: $constraint match $operator $version
     *
     * @param ConstraintInterface $constraint
     * @param int                 $operator
     * @phpstan-param Constraint::OP_*  $operator
     * @param string              $version
     *
     * @return mixed
     */
    public static function match(\_PhpScoperd47a2fa2a77e\Composer\Semver\Constraint\ConstraintInterface $constraint, $operator, $version)
    {
        if (self::$enabled === null) {
            self::$enabled = !\in_array('eval', \explode(',', \ini_get('disable_functions')), \true);
        }
        if (!self::$enabled) {
            return $constraint->matches(new \_PhpScoperd47a2fa2a77e\Composer\Semver\Constraint\Constraint(self::$transOpInt[$operator], $version));
        }
        $cacheKey = $operator . $constraint;
        if (!isset(self::$compiledCheckerCache[$cacheKey])) {
            $code = $constraint->compile($operator);
            self::$compiledCheckerCache[$cacheKey] = $function = eval('return function($v, $b){return ' . $code . ';};');
        } else {
            $function = self::$compiledCheckerCache[$cacheKey];
        }
        return $function($version, \strpos($version, 'dev-') === 0);
    }
}
