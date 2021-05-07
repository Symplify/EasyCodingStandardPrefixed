<?php

namespace Symplify\EasyTesting\DataProvider;

use Iterator;
use ECSPrefix20210507\Nette\Utils\Strings;
use ECSPrefix20210507\Symfony\Component\Finder\Finder;
use ECSPrefix20210507\Symfony\Component\Finder\SplFileInfo;
use Symplify\SmartFileSystem\Exception\FileNotFoundException;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
/**
 * @see \Symplify\EasyTesting\Tests\DataProvider\StaticFixtureFinder\StaticFixtureFinderTest
 */
final class StaticFixtureFinder
{
    /**
     * @return \Iterator
     * @param string $directory
     * @param string $suffix
     */
    public static function yieldDirectory($directory, $suffix = '*.php.inc')
    {
        $fileInfos = self::findFilesInDirectory($directory, $suffix);
        return self::yieldFileInfos($fileInfos);
    }
    /**
     * @return \Iterator
     * @param string $directory
     * @param string $suffix
     */
    public static function yieldDirectoryExclusively($directory, $suffix = '*.php.inc')
    {
        $fileInfos = self::findFilesInDirectoryExclusively($directory, $suffix);
        return self::yieldFileInfos($fileInfos);
    }
    /**
     * @return \Iterator
     * @param string $directory
     * @param string $suffix
     */
    public static function yieldDirectoryWithRelativePathname($directory, $suffix = '*.php.inc')
    {
        $fileInfos = self::findFilesInDirectory($directory, $suffix);
        return self::yieldFileInfosWithRelativePathname($fileInfos);
    }
    /**
     * @return \Iterator
     * @param string $directory
     * @param string $suffix
     */
    public static function yieldDirectoryExclusivelyWithRelativePathname($directory, $suffix = '*.php.inc')
    {
        $fileInfos = self::findFilesInDirectoryExclusively($directory, $suffix);
        return self::yieldFileInfosWithRelativePathname($fileInfos);
    }
    /**
     * @param SplFileInfo[] $fileInfos
     * @return \Iterator
     */
    private static function yieldFileInfos(array $fileInfos)
    {
        foreach ($fileInfos as $fileInfo) {
            try {
                $smartFileInfo = new SmartFileInfo($fileInfo->getRealPath());
                (yield [$smartFileInfo]);
            } catch (FileNotFoundException $fileNotFoundException) {
            }
        }
    }
    /**
     * @param SplFileInfo[] $fileInfos
     * @return \Iterator
     */
    private static function yieldFileInfosWithRelativePathname(array $fileInfos)
    {
        foreach ($fileInfos as $fileInfo) {
            try {
                $smartFileInfo = new SmartFileInfo($fileInfo->getRealPath());
                (yield $fileInfo->getRelativePathname() => [$smartFileInfo]);
            } catch (FileNotFoundException $e) {
            }
        }
    }
    /**
     * @return mixed[]
     * @param string $directory
     * @param string $suffix
     */
    private static function findFilesInDirectory($directory, $suffix)
    {
        $finder = Finder::create()->in($directory)->files()->name($suffix);
        $fileInfos = \iterator_to_array($finder);
        return \array_values($fileInfos);
    }
    /**
     * @return mixed[]
     * @param string $directory
     * @param string $suffix
     */
    private static function findFilesInDirectoryExclusively($directory, $suffix)
    {
        self::ensureNoOtherFileName($directory, $suffix);
        $finder = Finder::create()->in($directory)->files()->name($suffix);
        $fileInfos = \iterator_to_array($finder->getIterator());
        return \array_values($fileInfos);
    }
    /**
     * @return void
     * @param string $directory
     * @param string $suffix
     */
    private static function ensureNoOtherFileName($directory, $suffix)
    {
        $iterator = Finder::create()->in($directory)->files()->notName($suffix)->getIterator();
        $relativeFilePaths = [];
        foreach ($iterator as $fileInfo) {
            $relativeFilePaths[] = Strings::substring($fileInfo->getRealPath(), \strlen(\getcwd()) + 1);
        }
        if ($relativeFilePaths === []) {
            return;
        }
        throw new ShouldNotHappenException(\sprintf('Files "%s" have invalid suffix, use "%s" suffix instead', \implode('", ', $relativeFilePaths), $suffix));
    }
}
