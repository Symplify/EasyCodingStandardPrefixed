<?php

declare (strict_types=1);
namespace Symplify\SmartFileSystem\Tests\SmartFileSystem;

use _PhpScoperef5048aa2573\PHPUnit\Framework\TestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;
final class SmartFileSystemTest extends \_PhpScoperef5048aa2573\PHPUnit\Framework\TestCase
{
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    protected function setUp() : void
    {
        $this->smartFileSystem = new \Symplify\SmartFileSystem\SmartFileSystem();
    }
    public function testReadFileToSmartFileInfo() : void
    {
        $readFileToSmartFileInfo = $this->smartFileSystem->readFileToSmartFileInfo(__DIR__ . '/Source/file.txt');
        $this->assertInstanceof(\Symplify\SmartFileSystem\SmartFileInfo::class, $readFileToSmartFileInfo);
    }
}
