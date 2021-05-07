<?php

namespace Symplify\PackageBuilder\Parameter;

use ECSPrefix20210507\Symfony\Component\DependencyInjection\Container;
use ECSPrefix20210507\Symfony\Component\DependencyInjection\ContainerInterface;
use ECSPrefix20210507\Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
/**
 * @see \Symplify\PackageBuilder\Tests\Parameter\ParameterProviderTest
 */
final class ParameterProvider
{
    /**
     * @var array<string, mixed>
     */
    private $parameters = [];
    /**
     * @param Container|ContainerInterface $container
     */
    public function __construct($container)
    {
        $parameterBag = $container->getParameterBag();
        $this->parameters = $parameterBag->all();
    }
    /**
     * @param string $name
     * @return bool
     */
    public function hasParameter($name)
    {
        return isset($this->parameters[$name]);
    }
    /**
     * @api
     * @return mixed|null
     * @param string $name
     */
    public function provideParameter($name)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
    }
    /**
     * @api
     * @param string $name
     * @return string
     */
    public function provideStringParameter($name)
    {
        $this->ensureParameterIsSet($name);
        return (string) $this->parameters[$name];
    }
    /**
     * @api
     * @return mixed[]
     * @param string $name
     */
    public function provideArrayParameter($name)
    {
        $this->ensureParameterIsSet($name);
        return $this->parameters[$name];
    }
    /**
     * @api
     * @param string $parameterName
     * @return bool
     */
    public function provideBoolParameter($parameterName)
    {
        return isset($this->parameters[$parameterName]) ? $this->parameters[$parameterName] : \false;
    }
    /**
     * @return void
     * @param string $name
     */
    public function changeParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }
    /**
     * @api
     * @return mixed[]
     */
    public function provide()
    {
        return $this->parameters;
    }
    /**
     * @api
     * @param string $name
     * @return int
     */
    public function provideIntParameter($name)
    {
        $this->ensureParameterIsSet($name);
        return (int) $this->parameters[$name];
    }
    /**
     * @api
     * @return void
     * @param string $name
     */
    public function ensureParameterIsSet($name)
    {
        if (\array_key_exists($name, $this->parameters)) {
            return;
        }
        throw new ParameterNotFoundException($name);
    }
}
