<?php

declare (strict_types=1);
namespace Symplify\SmartFileSystem\Tests\Finder\FinderSanitizer;

use _PhpScoperfcee700af3df\Nette\Utils\Finder as NetteFinder;
use _PhpScoperfcee700af3df\Nette\Utils\Strings;
use _PhpScoperfcee700af3df\PHPUnit\Framework\TestCase;
use SplFileInfo;
use _PhpScoperfcee700af3df\Symfony\Component\Finder\Finder as SymfonyFinder;
use _PhpScoperfcee700af3df\Symfony\Component\Finder\SplFileInfo as SymfonySplFileInfo;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\SmartFileInfo;
final class FinderSanitizerTest extends \_PhpScoperfcee700af3df\PHPUnit\Framework\TestCase
{
    /**
     * @var FinderSanitizer
     */
    private $finderSanitizer;
    protected function setUp() : void
    {
        $this->finderSanitizer = new \Symplify\SmartFileSystem\Finder\FinderSanitizer();
    }
    public function testValidTypes() : void
    {
        $files = [new \SplFileInfo(__DIR__ . '/Source/MissingFile.php')];
        $sanitizedFiles = $this->finderSanitizer->sanitize($files);
        $this->assertCount(0, $sanitizedFiles);
    }
    public function testSymfonyFinder() : void
    {
        $symfonyFinder = \_PhpScoperfcee700af3df\Symfony\Component\Finder\Finder::create()->files()->in(__DIR__ . '/Source');
        $fileInfos = \iterator_to_array($symfonyFinder->getIterator());
        $this->assertCount(2, $fileInfos);
        $files = $this->finderSanitizer->sanitize($symfonyFinder);
        $this->assertCount(2, $files);
        $this->assertFilesEqualFixtureFiles($files[0], $files[1]);
    }
    public function testNetteFinder() : void
    {
        $netteFinder = \_PhpScoperfcee700af3df\Nette\Utils\Finder::findFiles('*')->from(__DIR__ . '/Source');
        $fileInfos = \iterator_to_array($netteFinder->getIterator());
        $this->assertCount(2, $fileInfos);
        $files = $this->finderSanitizer->sanitize($netteFinder);
        $this->assertCount(2, $files);
        $this->assertFilesEqualFixtureFiles($files[0], $files[1]);
    }
    /**
     * On different OS the order of the two files can differ, only symfony finder would have a sort function, nette
     * finder does not. so we test if the correct files are there but ignore the order.
     */
    private function assertFilesEqualFixtureFiles(\Symplify\SmartFileSystem\SmartFileInfo $firstSmartFileInfo, \Symplify\SmartFileSystem\SmartFileInfo $secondSmartFileInfo) : void
    {
        $this->assertFileIsFromFixtureDirAndHasCorrectClass($firstSmartFileInfo);
        $this->assertFileIsFromFixtureDirAndHasCorrectClass($secondSmartFileInfo);
        // order agnostic file check
        $this->assertTrue(\_PhpScoperfcee700af3df\Nette\Utils\Strings::endsWith($firstSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/FileWithClass.php') && \_PhpScoperfcee700af3df\Nette\Utils\Strings::endsWith($secondSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/EmptyFile.php') || \_PhpScoperfcee700af3df\Nette\Utils\Strings::endsWith($firstSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/EmptyFile.php') && \_PhpScoperfcee700af3df\Nette\Utils\Strings::endsWith($secondSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/FileWithClass.php'));
    }
    private function assertFileIsFromFixtureDirAndHasCorrectClass(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->assertInstanceOf(\_PhpScoperfcee700af3df\Symfony\Component\Finder\SplFileInfo::class, $smartFileInfo);
        $this->assertStringEndsWith('NestedDirectory', $smartFileInfo->getRelativeDirectoryPath());
    }
}
