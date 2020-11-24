<?php

declare (strict_types=1);
namespace Symplify\SymplifyKernel\Tests\Console\AbstractSymplifyConsoleApplication;

use _PhpScoperbd5fb781fe24\Symfony\Component\Console\Application;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use Symplify\SymplifyKernel\Tests\HttpKernel\PackageBuilderTestingKernel;
final class AutowiredConsoleApplicationTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    protected function setUp() : void
    {
        $this->bootKernel(\Symplify\SymplifyKernel\Tests\HttpKernel\PackageBuilderTestingKernel::class);
    }
    public function test() : void
    {
        $application = self::$container->get(\_PhpScoperbd5fb781fe24\Symfony\Component\Console\Application::class);
        $this->assertInstanceOf(\_PhpScoperbd5fb781fe24\Symfony\Component\Console\Application::class, $application);
    }
}
