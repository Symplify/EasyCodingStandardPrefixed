<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Composer;

use _PhpScopera9d6a31d814c\Composer\Autoload\ClassLoader;
use _PhpScopera9d6a31d814c\Nette\Utils\Strings;
use ReflectionClass;
/**
 * @see \Symplify\PackageBuilder\Tests\Composer\VendorDirProviderTest
 */
final class VendorDirProvider
{
    public function provide() : string
    {
        $rootFolder = \getenv('SystemDrive', \true) . \DIRECTORY_SEPARATOR;
        $path = __DIR__;
        while (!Strings::endsWith($path, 'vendor') && $path !== $rootFolder) {
            $path = \dirname($path);
        }
        if ($path !== $rootFolder) {
            return $path;
        }
        return $this->reflectionFallback();
    }
    private function reflectionFallback() : string
    {
        $reflectionClass = new ReflectionClass(ClassLoader::class);
        return \dirname($reflectionClass->getFileName(), 2);
    }
}
