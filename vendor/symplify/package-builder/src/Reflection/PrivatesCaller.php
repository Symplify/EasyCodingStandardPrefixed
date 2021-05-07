<?php

namespace Symplify\PackageBuilder\Reflection;

use ReflectionClass;
use ReflectionMethod;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
/**
 * @see \Symplify\PackageBuilder\Tests\Reflection\PrivatesCallerTest
 */
final class PrivatesCaller
{
    /**
     * @param object|string $object
     * @param mixed[] $arguments
     * @return mixed
     * @param string $methodName
     */
    public function callPrivateMethod($object, $methodName, array $arguments)
    {
        $this->ensureIsNotNull($object, __METHOD__);
        if (\is_string($object)) {
            $reflectionClass = new ReflectionClass($object);
            $object = $reflectionClass->newInstanceWithoutConstructor();
        }
        $methodReflection = $this->createAccessibleMethodReflection($object, $methodName);
        return $methodReflection->invokeArgs($object, $arguments);
    }
    /**
     * @param object|string $object
     * @return mixed
     * @param string $methodName
     */
    public function callPrivateMethodWithReference($object, $methodName, $argument)
    {
        $this->ensureIsNotNull($object, __METHOD__);
        if (\is_string($object)) {
            $reflectionClass = new ReflectionClass($object);
            $object = $reflectionClass->newInstanceWithoutConstructor();
        }
        $methodReflection = $this->createAccessibleMethodReflection($object, $methodName);
        $methodReflection->invokeArgs($object, [&$argument]);
        return $argument;
    }
    /**
     * @param object $object
     * @param string $methodName
     * @return \ReflectionMethod
     */
    private function createAccessibleMethodReflection($object, $methodName)
    {
        $reflectionMethod = new ReflectionMethod(\get_class($object), $methodName);
        $reflectionMethod->setAccessible(\true);
        return $reflectionMethod;
    }
    /**
     * @param mixed $object
     * @return void
     * @param string $location
     */
    private function ensureIsNotNull($object, $location)
    {
        if ($object !== null) {
            return;
        }
        $errorMessage = \sprintf('Value passed to "%s()" method cannot be null', $location);
        throw new ShouldNotHappenException($errorMessage);
    }
}
