<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper797695bcfb1f\Symfony\Component\DependencyInjection\Extension;

use _PhpScoper797695bcfb1f\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * ExtensionInterface is the interface implemented by container extension classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface ExtensionInterface
{
    /**
     * Loads a specific configuration.
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, \_PhpScoper797695bcfb1f\Symfony\Component\DependencyInjection\ContainerBuilder $container);
    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     */
    public function getNamespace();
    /**
     * Returns the base path for the XSD files.
     *
     * @return string|false
     */
    public function getXsdValidationBasePath();
    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     */
    public function getAlias();
}
/**
 * ExtensionInterface is the interface implemented by container extension classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
\class_alias('_PhpScoper797695bcfb1f\\Symfony\\Component\\DependencyInjection\\Extension\\ExtensionInterface', 'Symfony\\Component\\DependencyInjection\\Extension\\ExtensionInterface', \false);
