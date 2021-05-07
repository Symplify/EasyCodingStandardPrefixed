<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210507\Symfony\Component\DependencyInjection\Loader\Configurator;

use ECSPrefix20210507\Symfony\Component\DependencyInjection\Definition;
use ECSPrefix20210507\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DefaultsConfigurator extends \ECSPrefix20210507\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractServiceConfigurator
{
    const FACTORY = 'defaults';
    use Traits\AutoconfigureTrait;
    use Traits\AutowireTrait;
    use Traits\BindTrait;
    use Traits\PublicTrait;
    private $path;
    /**
     * @param \ECSPrefix20210507\Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator $parent
     * @param \ECSPrefix20210507\Symfony\Component\DependencyInjection\Definition $definition
     * @param string $path
     */
    public function __construct($parent, $definition, $path = null)
    {
        parent::__construct($parent, $definition, null, []);
        $this->path = $path;
    }
    /**
     * Adds a tag for this definition.
     *
     * @return $this
     *
     * @throws InvalidArgumentException when an invalid tag name or attribute is provided
     * @param string $name
     */
    public final function tag($name, array $attributes = [])
    {
        if ('' === $name) {
            throw new InvalidArgumentException('The tag name in "_defaults" must be a non-empty string.');
        }
        foreach ($attributes as $attribute => $value) {
            if (null !== $value && !\is_scalar($value)) {
                throw new InvalidArgumentException(\sprintf('Tag "%s", attribute "%s" in "_defaults" must be of a scalar-type.', $name, $attribute));
            }
        }
        $this->definition->addTag($name, $attributes);
        return $this;
    }
    /**
     * Defines an instanceof-conditional to be applied to following service definitions.
     * @param string $fqcn
     * @return \ECSPrefix20210507\Symfony\Component\DependencyInjection\Loader\Configurator\InstanceofConfigurator
     */
    public final function instanceof($fqcn)
    {
        return $this->parent->instanceof($fqcn);
    }
}
