<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper4575b9150b52\Symfony\Component\OptionsResolver\Exception;

use _PhpScoper4575b9150b52\Symfony\Component\OptionsResolver\Debug\OptionsResolverIntrospector;
/**
 * Thrown when trying to introspect an option definition property
 * for which no value was configured inside the OptionsResolver instance.
 *
 * @see OptionsResolverIntrospector
 *
 * @author Maxime Steinhausser <maxime.steinhausser@gmail.com>
 */
class NoConfigurationException extends \RuntimeException implements \_PhpScoper4575b9150b52\Symfony\Component\OptionsResolver\Exception\ExceptionInterface
{
}
